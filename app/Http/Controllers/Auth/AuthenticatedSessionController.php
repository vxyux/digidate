<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use PragmaRX\Google2FA\Google2FA;
use App\Models\QrManager;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $enable = QrManager::where('id', Auth::user()->qr_id)->pluck('google2fa_enable')->first();

        $greet = $this->randomize();

        // if 2fa has been set up in the profile
        if($enable == 1) {
            return view('auth.qr-verify')->with('success', 'Please, enter your one time code in order to verify your account');
        }
        else
        {
            return redirect()->intended(RouteServiceProvider::HOME)->with(compact('greet'));
        }
    }

    public function verifyQR(Request $request) {

        //comment zodat branch niet verwijderd wordt
        $google2fa = new Google2FA();

        $user = QrManager::where('id', Auth::user()->qr_id)->first();

        $secret = $request->input('one_time_password');

        $valid = $google2fa->verifyKey($user->google2fa_key, $secret);

        //the bypassing or statement is only intended for testing purposes, must remove @ reviews
        if ($valid == true || $secret == "bypass")
        {
            return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Your 2FA code is correct, enjoy our services.');
        }
        else
        {

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->back()->with('error', 'Your 2FA one time password was incorrect.');
        }
    }

    public function declined() {

        $user = User::where('id', Auth::user()->id)->update([
            'qr_id' => NULL
        ]);

        $query = QrManager::where('id', Auth::user()->qr_id);

        $query->delete();

        Return redirect('profile');

    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
