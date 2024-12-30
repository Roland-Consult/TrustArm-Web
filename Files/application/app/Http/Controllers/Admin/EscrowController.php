<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Escrow;
use App\Models\Milestone;
use App\Models\Transaction;
use App\Models\User;

class EscrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $pageTitle = "All Escrows";
        $escrows   =  Escrow::orderBy('id','desc')->with('category','seller','buyer')->paginate(getPaginate(10));
        return view('admin.escrow.list',compact('pageTitle','escrows'));
    }

    public function accepted()
    {
        $pageTitle  = "Accepted Escrow List";
        $escrows    = Escrow::where('status',2)->with('category','seller','buyer')->orderBy('id','desc')->paginate(getPaginate(10));
        return view('admin.escrow.accepted',compact('pageTitle','escrows'));
    }

    public function notAccepted()
    {
        $pageTitle  = "Not Accepted Escrow List";
        $escrows    = Escrow::where('status',0)->with('category','seller','buyer')->orderBy('id','desc')->paginate(getPaginate(10));

        return view('admin.escrow.not_accepted',compact('pageTitle','escrows'));
    }

    public function dispatched()
    {
        $pageTitle  = "Dispatched Escrow List";
        $escrows    = Escrow::where('status',1)->with('category','seller','buyer')->orderBy('id','desc')->paginate(getPaginate(10));
        return view('admin.escrow.dispatched',compact('pageTitle','escrows'));
    }
    public function disputed()
    {
        $pageTitle  = "Disputed Escrow List";
        $escrows    = Escrow::where('status',3)->with('category','seller','buyer')->orderBy('id','desc')->paginate(getPaginate(10));
        return view('admin.escrow.disputed',compact('pageTitle','escrows'));
    }

    public function action(Request $request)
    {
        $request->validate([
            'seller_amount' => 'required|numeric',
            'buyer_amount'  => 'required|numeric',
        ]);
        $escrow = Escrow::find($request->id);
        $escrow->status = $request->status;

        $charge = $escrow->funded_amount - ($request->seller_amount + $request->buyer_amount);

        if($charge < 0)
        {
            $notify[] = ['error','The charge will not be less than zero.'];
            return back()->withNotify($notify);
        }
        $escrow->save();

        if($request->seller_amount > 0)
        {
            $seller = $escrow->seller;
            $seller->balance += $request->seller_amount;
            $seller->save();

            $transaction = new Transaction();
            $transaction->user_id = $seller->id;
            $transaction->trx = getTrx();
            $transaction->trx_type = '+';
            $transaction->amount = $request->seller_amount;
            $transaction->post_balance = $seller->balance;
            $transaction->details = 'The admin has sent this amount to you from the escrow.';
            $transaction->save();

        }

        if($request->buyer_amount > 0)
        {
        $buyer              = $escrow->buyer;
            $buyer->balance += $request->buyer_amount;
            $buyer->save();

            $transaction                = new Transaction();
            $transaction->user_id       = $buyer->id;
            $transaction->trx           = getTrx();
            $transaction->trx_type      = '+';
            $transaction->amount        = $request->buyer_amount;
            $transaction->post_balance  = $buyer->balance;
            $transaction->details       = 'The admin has sent this amount to you from the escrow.';

            $transaction->save();

        }

        $action = [
            'fullname'=>auth()->user()->firstname,
            'username'=>auth()->user()->username,
            'mobile' =>auth()->user()->mobile,
            'email' => auth()->user()->email
        ];

        notify($action, 'ESCROW_DISPUTED_ACTION', [
            'escrow_title'      => $escrow->title,
            'escrow_amount'     => showAmount($escrow->amount),
            'buyer_amount'      =>  $request->buyer_amount,
            'seller_amount'     =>  $request->seller_amount,
            'number'            => $escrow->escrow_number,
            'fund'              => $escrow->funded_amount
        ]);

        $notify[] = ['success','Successful escrow transaction'];
        return back()->withNotify($notify);

    }

    public function canceled()
    {
        $pageTitle = "Canceled Escrow List";
        $escrows = Escrow::where('status',4)->with('category','seller','buyer')->orderBy('id','desc')->paginate(getPaginate(10));
        return view('admin.escrow.canceled',compact('pageTitle','escrows'));
    }


    public function details($id)
    {
        $pageTitle      = "Escrow Details";
        $escrow         = Escrow::findOrFail($id);
        $milestone      = Milestone::where('escrow_id',$id);
        $created        = $milestone->sum('amount');
        $funded        = $milestone->where('payment_type',1)->sum('amount');
        $unfunded       = $created - $funded ;
        $rest_amount    = ($escrow->amount + $escrow->buyer_charge)-$escrow->funded_amount;
        return view('admin.escrow.details',compact('pageTitle','escrow','created','funded','unfunded','rest_amount'));
    }


    public function milestone($id)
    {
        $pageTitle = "Escrow Milestone";

        $user        = auth()->user();
        $escrow      = Escrow::where('id',$id)->first();
        $milestones  = Milestone::where('escrow_id',$escrow->id)->orderBy('created_at','desc')->paginate(getPaginate());
     
        return view('admin.escrow.milestone',compact('pageTitle','escrow','milestones'));
    }

}
