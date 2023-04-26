<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blacklist;
use Illuminate\Support\Facades\Auth;

class BlockedController extends Controller
{
    public function index() {

        $blocked_users = blacklist::join('users', 'users.id', '=', 'blacklist.user_id_2')
            ->where(
                ['blacklist.created_at' => NULL],
                ['user_id' => Auth::user()->id]
            )
            ->get();


        return view('blocked.index')->with('blocked_users', $blocked_users);
    }

    public function unblock($id) {

        Blacklist::where('user_id_2', $id)->delete();

        return back()->with('success', 'You have successfully unblocked this user');

    }
}
