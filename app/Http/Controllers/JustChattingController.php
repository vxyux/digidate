<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sentences;
use Illuminate\Http\Request;
use App\Models\Matching;
use App\Models\User;
use App\Models\Chat;
use App\Models\Blacklist;

use Illuminate\Support\Facades\Auth;

class JustChattingController extends Controller
{
    public function index () {

        $select = $this->chat();

        $selected = 0;

        return view('chat.index')->with(compact('select', 'selected'))->with('id', Auth::user()->id);

    }

    public function match_chat ($id) {
        //shows list of ALL matches (div on the left side)
        $matches = $this->chat();

        //shows specific match with the ID parameter
        $select = $this->chat_user($id);

        $sentences = Sentences::all();

        foreach($sentences as $sentence){
            $old = $sentence->content;
            $sentence->content = str_replace('{{ user->first_name }}','(username)', $sentence->content);
        }


        //shows the chat feed according to match id
        $chat_feed = Chat::select('chats.sender_id', 'chats.text', 'chats.created_at', 'user.username', 'images.image')
            ->where('match_id', $select->id)
            ->join('users as user', 'chats.sender_id', '=', 'user.id')
            ->join('images', 'user.images_id', '=', 'images.id')
            ->orderby('chats.created_at', 'ASC')
            ->get();

//        dd($chat_feed);

        //match_id variable for the form cant use $chat_feed because it needs to be inside a foreach loop
        $match_id = $select->id;

        //changes to 1 so that the chat div will show in the blade
        $selected = 1;

        $retriever = $matches[0]->username2;

        if ($retriever == Auth::user()->username)
        {
            $retriever = $matches[0]->username1;
        }

        return view('chat.index')->with('select', $matches)
            ->with('data', $select)
            ->with('chat_data', $chat_feed)
            ->with('selected', $selected)
            ->with('match_id', $match_id)
            ->with('sentences', $sentences)
            ->with('retriever', $retriever)
            ->with('id', Auth::user()->id);
    }

    public function chat_with_user ($id, Request $request) {

        Chat::create([
            'sender_id'     => $request->my_id,
            'text'          => $request->my_text,
            'match_id'      => $id
        ]);

        return back();
    }

    public function use_sentences($id, Request $request) {

        $retriever = $request->retriever;

        $word = "{{";

        $line = str_replace("(username)", $retriever, $request->sentence);

        Chat::create([
            'sender_id'     => Auth::user()->id,
            'text'          => $line,
            'match_id'      => $id
        ]);

        return redirect()->back()->with('success', 'Used the sentence!');
    }

    public function unmatch(Request $request)
    {
        Chat::where('match_id', $request->mid)->delete();
        Matching::where('id', $request->mid)->delete();

        if ($request->u2 == Auth::user()->id)
        {
            Blacklist::create([
                'user_id' => Auth::user()->id,
                'user_id_2' => $request->u1
            ]);
        }
        else
        {
            Blacklist::create([
                'user_id' => Auth::user()->id,
                'user_id_2' => $request->u2
            ]);
        }

        return redirect()->route('chat.index')->with('success', 'You have successfully unmatched.');
    }

    public function block(Request $request)
    {
        Chat::where('match_id', $request->mid)->delete();
        Matching::where('id', $request->mid)->delete();

        if($request->u1 == Auth::user()->id) {

            Blacklist::create([
                'created_at' => NULL,
                'updated_at' => NULL,
                'user_id' => Auth::user()->id,
                'user_id_2' => $request->u2
            ]);
        }

        else {

            Blacklist::create([
                'created_at' => NULL,
                'updated_at' => NULL,
                'user_id' => Auth::user()->id,
                'user_id_2' => $request->u1
            ]);
        }

        return redirect()->route('chat.index')->with('success', 'You have successfully blocked this person.');
    }
}
