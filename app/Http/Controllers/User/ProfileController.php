<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Rules\FileTypeValidate;

class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = auth()->user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);

        $user = request()->user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        $user->address = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];

        $user->save();
        $message = 'Profile has been updated successfully';
        $notify[] = ['success', $message];
        return requestIsAjax() ? response()->json([
            'remark'=>'profile_updated',
            'status'=>'success',
            'message'=>$message,
        ]): back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {
        $passwordValidation = Password::min(6);
        $general = gs();
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$passwordValidation]
        ]);

        $messages = [
            'success'=>'Password change successfully',
            'error'=>'The password doesn\'t match!',
        ];

        $user = request()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();

            $status = 'success';
        } else {
            $status = 'error';
        }
        return requestIsAjax() ? 
            response()->json([
                'status'=>$status,
                'message'=>$messages[$status]
            ]) : 
            back()->withNotify($notify[] = [$status, $messages[$status]]);
    }

    public function imageUpdate(Request $request)
    {
        $this->validate($request, [
            'image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])]
        ]);
        $user = request()->user();
        if ($request->hasFile('image'))
        {
            $path = getFilePath('userProfile');
            fileManager()->removeFile($path.'/'.$user->image);
            $directory = $user->username."/". $user->id;
            $path = getFilePath('userProfile').'/'.$directory;
            $filename = $directory.'/'.fileUploader($request->image, $path, getFileSize('userProfile'));
            $user->image = $filename;
        }
        $user->save();

        $message = 'Profile image has been updated successfully';
        $notify[] = ['success', $message];
        return requestIsAjax() ? 
        response()->json([
            'status'=>'success',
            'message'=>$message
        ]) : to_route('user.home')->withNotify($notify);
    }
}
