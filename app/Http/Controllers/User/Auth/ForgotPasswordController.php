<?php

namespace App\Http\Controllers\User\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
        $this->activeTemplate = activeTemplate();
    }


    public function showLinkRequestForm()
    {
        $pageTitle = "Account Recovery";
        return view($this->activeTemplate . 'user.auth.passwords.email', compact('pageTitle'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        $request->validate([
            'id_card'=>'required'
        ]);
        $fieldType = $this->findFieldType();
        $user = User::where($fieldType, $request->id_card)->first();

        if (!$user) {
            $message = 'Couldn\'t find any account with this information';
            $notify[] = ['error', 'Couldn\'t find any account with this information'];
            return requestIsAjax() ? response()->json([
                'message'=>$message,
                'status'=>'success'
            ],422) : back()->withNotify($notify);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        PasswordReset::updateOrCreate([
            'email'=>$user->email,
        ],[
            'token'=>$code,
            'created_at'=>\Carbon\Carbon::now()
        ]);

        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();
        notify($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ],['email']);

        $email = $user->email;
        session()->put('pass_res_mail',$email);
        $message = 'Password reset email sent successfully';
        $notify[] = ['success', $message];
        return requestIsAjax() ? response()->json([
            'message'=>$message,
            'status'=>'success'
        ]) : to_route('user.password.code.verify')->withNotify($notify);
    }

    public function findFieldType()
    {
        $input = request()->input('id_card');

        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $input]);
        return $fieldType;
    }

    public function codeVerify(){
        $pageTitle = 'Verify Email';
        $email = session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error','Oops! session expired'];
            return to_route('user.password.request')->withNotify($notify);
        }
        return view($this->activeTemplate.'user.auth.passwords.code_verify',compact('pageTitle','email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required'
        ]);
        $code =  str_replace(' ', '', $request->code);

        if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $message = 'Verification code doesn\'t match';
            $notify[] = ['error', $message];
            return requestIsAjax() ? response()->json([
                'message'=>$message,
                'status'=>'fail'
            ],422) : to_route('user.password.request')->withNotify($notify);
        }

        $message = 'You can change your password';
        $notify[] = ['success', 'You can change your password.'];
        session()->flash('fpass_email', $request->email);
        return requestIsAjax() ? response()->json([
            'message'=>$message,
            'status'=>'success'
        ]) : to_route('user.password.reset', $code)->withNotify($notify);
    }

    public function reset(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json([
                'status'=>'error',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }

        $reset = PasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        
        if (!$reset) {
            $response[] = 'Invalid verification code.';
            return response()->json([
                'remark'=>'validation_error',
                'status'=>'error',
                'message'=>['success'=>$response],
            ],422);
        }

        $user = User::where('email', $reset->email)->first();
        $user->password = $request->password;
        $user->save();



        $userIpInfo = getIpInfo();
        $userBrowser = osBrowser();
        notify($user, 'PASS_RESET_DONE', [
            'operating_system' => @$userBrowser['os_platform'],
            'browser' => @$userBrowser['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ],['email']);

        $response[] = 'Password changed successfully';
        return response()->json([
            'remark'=>'password_changed',
            'status'=>'success',
            'message'=>['success'=>$response],
        ]);
    }

    protected function rules()
    {
        $passwordValidation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required','confirmed',$passwordValidation],
        ];
    }
}
