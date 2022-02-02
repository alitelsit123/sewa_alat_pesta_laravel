<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class UserVerification extends Controller
{
    public function showVerifyEmail()
    {
        return back()->with(['msg_warning' => 'Opps tidak bisa checkout. Emailmu belum diverifikasi. ', 'link' => '
        <form action="'.route("verification.resend").'" method="post">
            <input type="hidden" name="_token" value="'.csrf_token().'" />
            <button type="submit" class="btn tx-indigo">Verify sekarang.</button>
        </form>
        ', 'disable_unverify_notice' => true]);
    }
    public function resendEmailVerification() {
        auth()->user()->sendEmailVerificationNotification();

        return back()->with(['msg_success' => 'Verification link sent! <a class="mg-l-5" href="https://gmail.com" target="_blank">Cek Emailmu</a>', 'disable_unverify_notice' => true]);
    }
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/')->with(['msg_success' => 'Emailmu berhasil diverifikasi.']); // <-- change this to whatever you want
    }
}
