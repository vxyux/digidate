<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\Image;
use App\Models\Matching;
use App\Models\Tag;
use App\Models\Usertags;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class MatchmakingController extends Controller
{
    public function index(Request $request)
    {
        // get my tags (names)
        $tags = Usertags::where('user_id', Auth::user()->id)
            ->join('tags', 'user_tags.tag_id', '=', 'tags.id')
            ->pluck('name');

        $user = null;

        // declares user ids that alr passed
        $ids = $this->matchmaking();

        $damn = $this->filtered();

        $chosen = $request->filter;

        /*
         * This 'if' contributes to if the user has selected a filter
         * The 'damn' var is where all the users with the same interest are getting fetched
         * The 'instanceof' condition is only applicable when no users are found with the same interest
        */

        if ($request->filter != null)
        {
            foreach ($damn['counts'] as $record)
            {
                if ($record >= $chosen) {
                    // get main randomizers
                    $user = User::where('is_admin', 0)
                        ->inRandomOrder()
                        ->whereIn('users.id', $damn['id'])
                        ->first();
                }
            }
        }
        elseif($request->prev_id != null) // utilize this function when it comes back from 'show'
        {
            $user = User::where('id', $request->prev_id)->first();
        }
        else // no filter has been selected
        {
            // query to select all non admin user which are randomized
            $user = User::where('is_admin', 0)
                ->whereNotIn('users.id', $ids)
                ->join('images','users.images_id', '=', 'images.id')
                ->where('users.id', '!=', Auth::user()->id)
                ->inRandomOrder()
                ->select('users.id AS u1', 'users.*', 'images.*')
                ->first();
        }

        if ($user != null)
        {

            $other_tags = Usertags::where('user_id', $user->id)
                ->join('tags', 'user_tags.tag_id', '=', 'tags.id')
                ->pluck('tags.name');

//            $image = Image::where('id', $user->images_id)->get();

            return view('matchmaking.index')->with(compact('user', 'tags', 'other_tags', 'chosen'));
        }

        return view('matchmaking.index')->with(compact('user', 'tags'   , 'chosen'));
    }

    public function show(Request $request)
    {
        $id = $request->user_id;

        $user = User::where('id', $id)->first();

        // main function for the fetching the other user's their tags
        $other_tags = Usertags::where('user_id', $id)
            ->join('tags', 'user_tags.tag_id', '=', 'tags.id')
            ->pluck('tags.name');

        if ($user == null)
        {
            $images = null;
        }
        else
        {
            $images = Image::where('id', $user->images_id)->get();
        }

        return view('matchmaking.show')->with(compact('user', 'images', 'other_tags'));
    }

    public function like(Request $request)
    {
        $id = $request->user;

        $prev = Matching::whereIn('user_id', [Auth::user()->id, $id])
            ->whereIn('user_id_2', [Auth::user()->id, $id])
            ->first();

        if ($prev == null)
        {
            $matching = Matching::create([
                'user_id' => Auth::user()->id,
                'user_id_2' => $request->user,
                'liked' => 1,
                'liked_2' => 0,
                'activated' => 0,
            ]);
        }
        else
        {
            if ($prev->user_id == null) // if user_id 1 in matches is null
            {
                $prev->user_id = Auth::user()->id;
            }
            else
            {
                $prev->user_id_2 = Auth::user()->id;
            }

            if ($prev->liked == null) // if liked 1 is empty
            {
                $prev->liked = 1;
            }
            else // if liked 2 is empty
            {
                $prev->liked_2 = 1;
            }
            $prev->update();
        }

        return redirect()->route('matchmaking.index');
    }

    public function decline(Request $request)
    {
        $blacklist = Blacklist::create([
            'user_id' => Auth::user()->id,
            'user_id_2' => $request->user,
        ]);

        return redirect()->route('matchmaking.index');
    }

    public function filter(Request $request)
    {
        // number of tags selected in the dropdown select (1-5)
        $num = $request->tags;
    }

    public function back($id)
    {
        return redirect()->route('matchmaking.index')->with(compact('id'));
    }
}
