<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Phone;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.user.login_form');
    }

    public function loginPost(Request $request)
    {
        $validation = $request->validate([
            'phone' => 'required',
        ]);

        $phone = 998 . preg_replace('/[^0-9]/ui', "", $request->input('phone'));
        if (strlen($phone) != 12) {
            return back()->withErrors(['phone' => __('auth.login_form.phone_length_error')]);
        }

        $user_phone = Phone::where('number', $phone)->with('user')->first();
        if ($user_phone != null) {
//            $sms_code = SmsService::sendSms($phone);
            $sms_code = 111111;
            Phone::where('number', $phone)->update([
                'sms' => $sms_code,
            ]);
            return redirect()->route('sms_check', ['id' => $user_phone->id])
                ->with('success', __('auth.sms_form.sms_code_description'));

        } else {
            return back()->withErrors(['phone' => __('auth.login_form.phone_has_error')]);
        }
    }

    public function smsCheckForm($id)
    {
        return view('auth.user.sms_form', compact('id'));
    }

    public function smsCheckPost(Request $request)
    {
        $validation = $request->validate([
            'sms' => 'required',
        ]);
        $sms = $request->input('sms');

        if(strlen($sms) != 6) {
            return back()->withErrors(['sms' => __('auth.sms_form.sms_error')]);
        }

        $phone = Phone::where('id', $request->input('id'))->first();
        if($phone->sms == $sms) {
            $user = User::where('id', $phone->user_id)->first();
            Auth::guard('web')->login($user);
            return redirect()->route('auth.user.index');
        } else {
            return back()->withErrors(['sms' => __('auth.sms_form.sms_error')]);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
