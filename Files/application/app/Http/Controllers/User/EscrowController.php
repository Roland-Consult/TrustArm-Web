<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Escrow;
use App\Models\Category;
use App\Models\User;
use App\Models\Transaction;
use App\Models\EscrowCharge;
use App\Models\GeneralSetting;
use App\Models\Milestone;
use App\Models\Message;
use App\Models\Conversation;
use Faker\Core\Number;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class EscrowController extends Controller
{

    public function list($type = null)
    {
        $pageTitle = 'All Escrow';
        $general = GeneralSetting::first();
        $escrows = Escrow::where(function($query){
                    $query->where('seller_id', auth()->user()->id)->orWhere('buyer_id',auth()->user()->id);
        });

        if($type == 'not_accepted')
        {
            $escrows->where('status',0);
        }
        elseif($type == 'dispatched')
        {
            $escrows->where('status',1);
        }
        elseif($type == 'accepted')
        {
            $escrows->where('status',2);
        }
        elseif($type == 'disputed')
        {
            $escrows->where('status',3);
        }
        elseif($type == 'canceled')
        {
            $escrows->where('status',4);
        }
        $escrows = $escrows->with('buyer','seller','category')->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate .'user.escrow.log',compact('pageTitle','escrows','general'));
    }

    public function create()
    {
        $pageTitle = "New Escrow";
        $categories = Category::where('status', 1)->get();

        return view($this->activeTemplate . 'user.escrow.new', compact('pageTitle', 'categories'));
    }

    public function info(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:1,2',
            "category_id" => "required",
            "amount"      => "numeric"
        ]);
        $general = GeneralSetting::first();

        $escrowCharge   = EscrowCharge::firstOrFail();

        if (($escrowCharge->min_amount <= $request->amount) && ($escrowCharge->max_amount >= $request->amount)) {

            $charge =  $escrowCharge->fixed_charge + $request->amount * ($escrowCharge->percent_charge / 100);
        } else {
            $charge =  $general->fixed_charge + $request->amount * ($general->percent_charge / 100);
        }

        session()->put('type', $request->type);
        session()->put('category_id', $request->category_id);
        session()->put('amount', $request->amount);
        session()->put('session_charge', $charge);

        return redirect()->route('user.escrow.submitInformation');
    }

    public function submitInformation(Request $request)
    {
        $pageTitle = "Submit all information";

        $type      = session()->get('type');
        $category_id = session()->get('category_id');
        $amount    = session()->get('amount');
        $session_charge = session()->get('session_charge');

        return view($this->activeTemplate . 'user.escrow.submitInformation', compact('pageTitle', 'type', 'category_id', 'amount', 'session_charge'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string',
            "email"         => "required",
            "charge_sender"  => "required",
        ]);

        $escrow   = new Escrow();
        $escrow->title = $request->title;
        $is_user    = User::where('email', $request->email)->first();

        if ($request->type == 1) {
            $escrow->seller_id = auth()->user()->id;
            if ($is_user) {
                $escrow->buyer_id  =   $is_user->id;
            } else {
                $escrow->buyer_id  = 0;
            }
        } else {
            $escrow->buyer_id   = auth()->user()->id;
            if ($is_user) {
                $escrow->seller_id  = $is_user->id;
            } else {
                $escrow->seller_id = 0;
            }
        }

        if ($request->charge_sender == 1) {
            $escrow->seller_charge = $request->charge;
        } elseif ($request->charge_sender == 2) {
            $escrow->buyer_charge = $request->charge;
        } else {
            $escrow->seller_charge = $request->charge / 2;
            $escrow->buyer_charge  = $request->charge / 2;
        }

        $escrow->inventor_id       = auth()->user()->id;
        $escrow->escrow_number     = getTrx();
        $escrow->category_id       = $request->category_id;
        $escrow->amount            = $request->amount;
        $escrow->charge            = $request->charge;
        $escrow->charge_sender     = $request->charge_sender;
        $escrow->details           = $request->details;
        $escrow->mail_invitation   = $request->email;


        $escrow->save();

        $conversation               = new Conversation();
        $conversation->escrow_id    = $escrow->id;
        $conversation->seller_id    = $escrow->seller_id;
        $conversation->buyer_id     = $escrow->buyer_id;
        $conversation->save();

        $user = auth()->user()->email;

        $invite_user = [
            'fullname' => $is_user->firstname ?? '',
            'username' => $is_user->username ?? '',
            'mobile' => $is_user->mobile ?? '',
            'email' => $escrow->mail_invitation
        ];

        notify($invite_user, 'INVITATION_MAIL', [
            'sender_mail'        => $user,
            'escrow_amount' => showAmount($escrow->amount),
            'link'          => url('/') . '/user/register',

        ]);

        $notify[] = ['success', 'Escrow created sucessfully'];
        return to_route('user.escrow.list')->withNotify($notify);
    }


    public function details($id)
    {
        $pageTitle              = "Escrow Details";
        $escrow                 = Escrow::where('id', $id)->with('conversation')->first();
        $milestone              = Milestone::where('escrow_id', $id);
        $created                = $milestone->sum('amount');
        $funded                 = $milestone->where('payment_type', 1)->sum('amount');
        $unfunded               = $created - $funded;
        $rest_amount            = ($escrow->amount + $escrow->buyer_charge) - $escrow->funded_amount;
        $conversation           = $escrow->conversation->first();
        $messages               = Message::where('conversation_id', $conversation->id)->with('conversation')->get();

        return view($this->activeTemplate . 'user.escrow.details', compact('pageTitle', 'escrow', 'rest_amount', 'created', 'funded', 'unfunded', 'messages', 'conversation'));
    }


    public function accepted(Request $request, $id)
    {
        $escrow = Escrow::findOrFail($id);
        $escrow->status = 2;
        $escrow->save();
        if ($escrow->seller_id == auth()->user()->id) {
            $accepter = 'Seller';
        } else {
            $accepter = 'Buyer';
        }

        $acceptation_mail = [
            'fullname' => auth()->user()->firstname,
            'username' => auth()->user()->username,
            'mobile' => auth()->user()->mobile,
            'email' => auth()->user()->email
        ];

        notify($acceptation_mail, 'ESCROW_ACCEPTED', [

            'escrow_amount' => showAmount($escrow->amount),
            'accepter'      => $accepter,
            'escrow_number' => $escrow->escrow_number,

        ]);

        return redirect()->back();
    }

    public function cancel($id)
    {

        $is_cancel  = Escrow::where('id', $id)->where('status', 4)->first();
        if ($is_cancel) {
            $notify[] = ['error', 'This escrow has already been cancelled.'];
            return redirect()->back()->withNotify($notify);
        }

        $escrow = Escrow::where('id', $id)->where('status', '!=', 4)->first();
        $buyer  = $escrow->buyer;

        $escrow->status = 4;
        $escrow->save();

        $refund_amount  = $escrow->funded_amount;

        // dd($refund_amount);

        if ($refund_amount < 1) {
            $notify[] = ['success', 'Successfully cancellation of escrow'];
            return redirect()->back()->withNotify($notify);
        }

        $buyer->balance             += $refund_amount;
        $buyer->save();


        $transaction                = new Transaction();
        $transaction->user_id       = $buyer->id;
        $transaction->amount        = $refund_amount;
        $transaction->charge        = 0;
        $transaction->trx           = getTrx();
        $transaction->post_balance  = $buyer->balance;
        $transaction->trx_type      = '+';
        $transaction->details       = 'Refund of the Milestone payment for closing the escrow';

        $transaction->save();

        if ($escrow->seller_id == auth()->user()->id) {
            $canceler = 'Seller';
        } else {
            $canceler = 'Buyer';
        }

        $cancelation_mail = [
            'fullname' => auth()->user()->firstname,
            'username' => auth()->user()->username,
            'mobile' => auth()->user()->mobile,
            'email' => auth()->user()->email
        ];

        notify($cancelation_mail, 'ESCROW_CANCELED', [
            'escrow_number' => $escrow->escrow_number,
            'escrow_amount' => showAmount($escrow->amount),
            'canceler'      => $canceler,
            'fund'          => showAmount($refund_amount)
        ]);

        $notify[]   =   ['success', 'Successfully cancellation of escrow'];
        return redirect()->back()->withNotify($notify);
    }

    public function dispatch($id)
    {
        $escrow   = Escrow::where('id', $id)->where('status', 2)->first();

        $escrow->status = 1;
        $escrow->save();

        $amount = $escrow->amount - $escrow->seller_charge;
        $seller = $escrow->seller;
        $seller->balance += $amount;

        $seller->save();

        $transaction = new Transaction();
        $transaction->user_id   = $seller->id;
        $transaction->amount    = $amount;
        $transaction->charge    = 0;
        $transaction->post_balance  = $seller->balance;
        $transaction->trx_type      = '+';
        $transaction->trx           = getTrx();
        $transaction->details       = 'Withdrawals of escrow funds.';

        $transaction->save();

        $dispatched = [
            'fullname' => $escrow->seller->firstname,
            'username' => $escrow->seller->username,
            'mobile' => $escrow->seller->mobile,
            'email' => $escrow->seller->email
        ];

        notify($dispatched, 'DISPATCHED_ESCROW', [
            'escrow_amount' => showAmount($escrow->amount),
            'post_balance'  => showAmount($seller->balance),

        ]);

        $notify[]   = ['success', 'Successful dispatch of the escrow payment'];
        return redirect()->back()->withNotify($notify);
    }

    public function dispute(Request $request)
    {
        $request->validate([
            "note"  => 'required',
        ]);
        $escrow    =   Escrow::findOrFail($request->id);
        $escrow->disputer_id = auth()->user()->id;
        $escrow->status    = 3;
        $escrow->dispute_reason   = $request->note;
        $escrow->save();

        if ($escrow->seller_id == auth()->user()->id) {
            $disputer = 'Seller';
        } else {
            $disputer = 'Buyer';
        }

        $dispute_mail = [
            'fullname' => auth()->user()->firstname,
            'username' => auth()->user()->username,
            'mobile' => auth()->user()->mobile,
            'email' => auth()->user()->email
        ];

        notify($dispute_mail, 'ESCROW_DISPUTED', [

            'escrow_amount' => showAmount($escrow->amount),
            'disputer'      => $disputer,
            'escrow_number'        => $escrow->escrow_number,
            'distails'      => $request->note
        ]);
        $notify[]               =   ['success', 'Escrow is  Successfully disputed'];
        return back()->withNotify($notify);
    }

    public function milestone($id)
    {

        $pageTitle    = "Escrow Milestones";
        $user         = auth()->user();
        $escrow       = Escrow::where('id', $id)->first();
        $rest_amount  =   ($escrow->amount + $escrow->buyer_charge) - $escrow->funded_amount;
        $milestones   = Milestone::where('escrow_id', $escrow->id)->with('escrow')->orderBy('created_at', 'desc')->get();

        return view($this->activeTemplate . 'user.escrow.milestone', compact('pageTitle', 'escrow', 'milestones', 'rest_amount'));
    }

    public function addMilestone(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'note' => 'required',
            'amount' => 'numeric|min:1'
        ]);

        $escrow          =   Escrow::where('id', $id)->first();

        $rest_amount     =   ($escrow->amount + $escrow->buyer_charge) - $escrow->funded_amount;

        // dd($rest_amount);

        // var_dump($request->amount);
        // exit();

        if ($request->amount > round($rest_amount, 2)) {
            $notify[]               =   ['error', 'Request amount can\'t greater than rest amount'];
            return back()->withNotify($notify);
        }


        $milestone                  =   new Milestone();
        $milestone->escrow_id       =   $request->escrow_id;
        $milestone->user_id         =   auth()->user()->id;
        $milestone->details         =   $request->note;
        $milestone->amount          =   $request->amount;

        if ($rest_amount != $escrow->funded_amount) {
            $milestone->payment_type = 0;
        } else {
            $milestone->payment_type = 1;
        }

        $milestone->save();

        $notify[] =   ['success', 'Milestone created successfully!'];
        return redirect()->back()->withNotify($notify);
    }

    public function conversations($id)
    {
        $pageTitle = "Conversations";
        $escrow                 = Escrow::where('id', $id)->with('conversation')->first();
        $conversation = $escrow->conversation->first();
        $messages = Message::where('conversation_id', $conversation->id)->with('conversation')->get();
        return view($this->activeTemplate . "user.escrow.conversations", compact('pageTitle', 'escrow', 'messages', 'conversation'));
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message'   => 'required'
        ]);

        $conversation = Conversation::where('escrow_id', $id)->first();
        $message    =   new Message();
        $message->conversation_id = $conversation->id;
        $message->sender_id = auth()->user()->id;
        $message->message = $request->message;
        $message->save();

        return redirect()->back();
    }
}
