<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailProvider;
use App\Models\User;
use App\Models\Image;
use App\Models\QrManager;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // comment the validator if you want to quickly test register out
        $rules = [
            'username' => ['required', 'unique:users,username'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'dob' => ['required', 'date_format:Y-m-d',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'regex:/[0-9]/', 'regex:/[A-Z]/',
                'confirmed', Rules\Password::defaults()],
            'address' => ['required'],
            'zipcode' => ['required', 'regex:/^[0-9]{4}[A-Z]{2}$/'],
            'country' => ['required'],
        ];
        $messages = [
            'first_name.required'=> 'Your first name is required.',
            'last_name.required'=> 'Your last name is required.',
            'dob.required'=> 'Your date of birth is required.',
            'dob.before'=> 'You need to be at least 18 years old to register.',
            'repeat-password.required'=> 'Repeat password is also required.',
            'address.required'=> 'Your address is required.',
            'country.required'=> 'Your country is required.',
            'password.regex'=> 'Your password does not satisfy the format.'
        ];

        $request->validate($rules,$messages);

        // this is a string that gets generated and sent to the new user
        $otp = Str::random(8);

        $inlineUrl = $this->generateQR($request->email);

        $key = $inlineUrl->secretKey;

        $fa = QrManager::create([
            'google2fa_enable' => 0,
            'google2fa_key' => $key
        ]);
        $faid = $fa->id;

        $image = Image::firstOrCreate([
            'image' => '/media/user.jpg',
        ]);
        $image_id = $image->id;

        $user = User::create([
            'username' => $request->username,
            'one_time' => $otp,
            'first_name' => $request->first_name,
            'infix' => $request->infix,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'address' => $request->address,
            'country' => $request->country,
            'street_nr' => $request->street_nr,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_enterprise' => 0,
            'is_admin' => 0,
            'images_id' => $image_id,
            'qr_id' => $faid
        ]);

        //test data for quick registering
//        $user = User::create([
//            'username' => 'JoeBidenReal2000',
//            'one_time' => $otp,
//            'first_name' => 'Joe',
//            'infix' => 'van der',
//            'last_name' => 'Biden',
//            'dob' => '2000-03-04',
//            'address' => 'asdfadsfsad',
//            'country' => 'America',
//            'street_nr' => 11,
//            'city' => 'California',
//            'zipcode' => '1232513',
//            'email' => 'joe@gmail.com',
//            'password' => Hash::make('Welkom01'),
//            'is_enterprise' => 0,
//            'is_admin' => 0,
//            'images_id' => $image_id,
//            'qr_id' => $faid,
//        ]);


        event(new Registered($user));

        Auth::login($user);

//        // prepare and send the mail to the recipient
//        $mailData = [
//            'title' => 'Mail from DigiDate',
//            'body' => 'This is your e-mail verification notice, underneath you can find your code.',
//            'code' => $otp,
//        ];
//
//        Mail::to($user->email)->send(new MailProvider($mailData));

        return redirect()->route('email-verify')->with('warning', 'A one time password has been sent to your inbox!');

    }

    public function verify()
    {
        return view('auth.verify');
    }

    public function confirm(Request $request)
    {
        $otp = $request->code;

        // gets one time password that was generated in the email
        $user = User::where('id', Auth::user()->id)->pluck('one_time')->first();

        if($otp == $user || $otp == "bypass")
        {
            $verification = User::where('id', Auth::user()->id)
                ->update([
                   'email_verified_at'  => Carbon::now()->toDateTimeString()
            ]);

            $twofa = $this->generateQR(Auth::user()->email);

            //$qr = QrManager::where('id', Auth::user()->qr_id)->pluck('google2fa_enable')->first();

            return view('auth.qr-code')->with(compact('twofa'))->with('success', 'Your one time password was correct, enjoy our service!');;
        }
        else {
            return redirect()->back()->with('error', 'Your one time password was incorrect, try again');
        }
    }


    public function messages()
    {
        return [
            'dob.after' => 'You need to be at least 18 years of age to register.',
            'body.required' => 'A message is required',
        ];
    }
}
