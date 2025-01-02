<?php

namespace App\Http\Controllers\User;

use App\Models\Form;
use App\Models\Escrow;
use App\Models\Deposit;
use App\Lib\FormProcessor;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle                  = 'Dashboard';
        $user                       = auth()->user();
        $user['balance']            = $user->balance;
        $user['deposit_pending']    = Deposit::where('user_id',$user->id)->where('status',2)->count();
        $user['withdraw_pending']   = Withdrawal::where('user_id',$user->id)->where('status',2)->count();

        $escrows = Escrow::selectRaw('status, COUNT(*) as count')
                            ->where('seller_id', auth()->user()->id)
                            ->orWhere('buyer_id', auth()->user()->id)
                            ->groupBy('status')
                            ->pluck('count', 'status');

        $escrow['total']        = $escrows->sum();
        $escrow['not_accepted'] = $escrows->get(0,0);
        $escrow['dispatched']   = $escrows->get(1,0);
        $escrow['running']      = $escrows->get(2,0);
        $escrow['disputed']     = $escrows->get(3,0);
        $escrow['canceled']     = $escrows->get(4,0);

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle','user','escrow'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = request()->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx',$request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function depositPending(Request $request)
    {
        $pageTitle = 'Pending Deposits';
        $user = auth()->user();
        $deposits = Deposit::where('user_id', $user->id)->where('status',2)->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        if ($request->search) {
            // dd('hi');
            $deposits = $deposits->where('trx', $request->search);
        }
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general = gs();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = request()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = request()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('user_id',auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx',$request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type',$request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark',$request->remark);
        }

        $transactions = $transactions->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.transactions', compact('pageTitle','transactions','remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == 2) {
            $message = 'Your KYC is under review';
            $notify[] = ['error','Your KYC is under review'];
            return requestIsAjax() ? response()->json([
                'remark'=>'under_review',
                'status'=>'success',
                'message'=>$message,
            ]) : to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == 1) {
            $message = 'You are already KYC verified';
            $notify[] = ['success',$message];
            return requestIsAjax() ? response()->json([
                'remark'=>'already_verified',
                'status'=>'error',
                'message'=>$message,
            ]) : to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act','kyc')->first();

        $notify[] = 'KYC field is below';
        return requestIsAjax() ? response()->json([
            'remark'=>'kyc_form',
            'status'=>'success',
            'message'=>['success'=>$notify],
            'data'=>[
                'form'=>$form->form_data
            ]
        ]): view($this->activeTemplate.'user.kyc.form', compact('pageTitle','form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate.'user.kyc.info', compact('pageTitle','user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act','kyc')->first();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);
        $user = request()->user();
        $user->kyc_data = $userData;
        $user->kv = 2;
        $user->save();

        $message = 'KYC data submitted successfully';
        $notify[] = ['success',$message];
        return requestIsAjax() ? response()->json([
            'status'=>'success',
            'message'=>$message ,
        ]): to_route('user.home')->withNotify($notify);

    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name).'- attachments.'.$extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate.'user.user_data', compact('pageTitle','user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = request()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country'=>@$user->address->country,
            'address'=>$request->address,
            'state'=>$request->state,
            'zip'=>$request->zip,
            'city'=>$request->city,
        ];
        $user->reg_step = 1;
        $user->save();

        $notify[] = ['success','Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);

    }

    public function submitProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname'=>'required',
            'lastname'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark'=>'validation_error',
                'status'=>'error',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }

        $user = request()->user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country'=>@$user->address->country,
            'address'=>$request->address,
            'state'=>$request->state,
            'zip'=>$request->zip,
            'city'=>$request->city,
        ];
        $user->save();

        $notify[] = 'Profile has been updated successfully';
        return response()->json([
            'remark'=>'profile_updated',
            'status'=>'success',
            'message'=>['success'=>$notify],
        ]);
    }
}
