<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\MailProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crud = User::select()->get();

//            dd($crud);

        return view('admin_users.index')->with('crud', $crud);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'dob' => ['required', 'date_format:Y-m-d',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed',
                'confirmed', Rules\Password::defaults()],
            'address' => ['required'],
            'country' => ['required'],
        ];
        $messages = [
            'first_name.required'=> 'Your first name is required',
            'last_name.required'=> 'Your last name is required',
            'dob.required'=> 'Your date of birth is required',
            'dob.before'=> 'You need to be at least 18 years old to register',
            'repeat-password.required'=> 'Repeat password is also required.',
            'address.required'=> 'Your address is required',
            'country.required'=> 'Your country is required',
        ];

        $request->validate($rules,$messages);

        $otp = Str::random(8);

        $user = User::create([
            'one_time' => $otp,
            'username' => $request->username,
            'first_name' => $request->first_name,
            'infix' => $request->infix,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'address' => $request->address,
            'country' => $request->country,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_enterprise' => 0,
            'is_admin' => 1,
            'images_id' => null,
        ]);

        $mailData = [
            'title' => 'Mail from DigiDate',
            'body' => 'This is your e-mail verification notice, underneath you can find your code.',
            'code' => $otp,
        ];

        Mail::to($request->email)->send(new MailProvider($mailData));


        return redirect('admin_users')->with('success', 'A mail has been sent with a special code inside.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return redirect('admin_users')->with('success', "You have deleted a user! They/Them won't find there love here anymore");

    }
}
