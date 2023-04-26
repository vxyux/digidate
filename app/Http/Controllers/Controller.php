<?php

namespace App\Http\Controllers;



use App\Models\Matching;
use App\Models\Blacklist;
use App\Models\Usertags;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Auth;
use App\Models\QrManager;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateQR($holder)
    {
        $google2fa = new Google2FA();

        $secret = $google2fa->generateSecretKey();

        $QRcode = $google2fa->getQRCodeInline(
            "digidate",
            $holder,
            $secret
        );

        $x = array(
            'QRcode' => $QRcode,
            'secretKey' => $secret
        );

        return (object)$x;
    }

    public function statusQR($id, Request $request)
    {
        if ($request->type == 0)
        {
            if ($id == 1)
            {
                QrManager::where('id', Auth::user()->qr_id)->update([
                    'google2fa_enable' => 1
                ]);
            }

            return redirect()->route('profile.edit')->with('success', 'Your 2FA has been set.');
        }
        else
        {
            if ($id == 0) // declined 2FA
            {
                QrManager::where('id', Auth::user()->qr_id)->update([
                    'google2fa_enable' => 0
                ]);

                return redirect()->route('profile.edit')->with('warning', 'To increase account security, please setup your 2FA QR code.');
            }
            else if($id == 2) // redo 2FA
            {
                $twofa = $this->generateQR(Auth::user()->email);

                QrManager::where('id', Auth::user()->qr_id)->update([
                    'google2fa_enable' => 0,
                    'google2fa_key' => $twofa->secretKey,
                ]);

                return view('auth.qr-code')->with(compact('twofa'));
            }
            else // accepted 2FA
            {
                QrManager::where('id', Auth::user()->qr_id)->update([
                    'google2fa_enable' => 1
                ]);

                return redirect()->route('profile.edit')->with('success', 'Your 2FA has been set.');
            }
        }
    }

    public function randomize()
    {
        $sentences = [
            'Looking good today, '. Auth::user()->first_name,
            'Caught you in 4k.',
            'Have you programmed today?',
            'What color is your Bugatti?',
            'Keep on searching, '. Auth::user()->first_name,
            'Wanna hop in a vc call?',
            'ERROR: $love has not been found',
            'Are you an exception? Let me catch you.',
            'Are you sitting on the F5 key, cuz your ass is refreshing.',
            'Be the hard drive of my dreams',
            'Hey baby, let me hack your kernel. ',
            'Happy hunting!',
            'What do you wanna tell Joe Biden right now?',
            'Wassup baby, take me out to dinner..?',
            'I LOVE ANIME BTW',
            'I AM A DISCORD ADMIN BTW haha RIZZZZZZ',
            'My name is jeff',
        ];

        $random = rand(0,16);

        return $sentences[$random];
    }

    function dash()
    {
//        $image = Image::select('image')
//            ->Where('image.id', Auth::user()->id)
//            ->get();

        $greet = $this->randomize();

//        return view('dashboard')->with(compact('greet'));
        return view('dashboard',[
            'greet' => $greet,
        ]);
    }

    public function chat()
    {
        $name = Auth::user()->id;

        $select = Matching::join('users as u1', 'matches.user_id', '=', 'u1.id')
            ->join('users as u2', 'matches.user_id_2', '=', 'u2.id')
            ->join('images as images_1', 'u1.images_id', '=', 'images_1.id')
            ->join('images as images_2', 'u2.images_id', '=', 'images_2.id')
            ->select('u1.username AS username1', 'u2.username AS username2', 'images_1.image as image1', 'images_2.image as image2', 'u1.id as id1', 'u2.id as id2', 'matches.id', 'matches.liked', 'matches.liked_2')
            ->whereRaw('matches.liked = 1 AND matches.liked_2 = 1')
            ->where(function($query) use ($name) { //This functions as a double where
                $query->where('u1.id', $name ) //OR where statement
                    ->orWhere('u2.id', $name );
            })

            ->get();


        return $select;
    }

    public function chat_user($id)
    {
        // get all messages
        $select = Matching::select('u1.username AS username1', 'u2.username AS username2', 'images_1.image as image1', 'images_2.image as image2', 'u1.id as id1', 'u2.id as id2', 'matches.id')
            ->join('users as u1', 'matches.user_id', '=', 'u1.id')
            ->join('users as u2', 'matches.user_id_2', '=', 'u2.id')
            ->join('images as images_1', 'u1.images_id', '=', 'images_1.id')
            ->join('images as images_2', 'u2.images_id', '=', 'images_2.id')
            ->where('matches.id', $id)
            ->first();

        return $select;

    }

    public function matchmaking()
    {
        // get all already matched users and get their id's
        $match = Matching::where('user_id', Auth::user()->id)
            ->where('liked', 1)
            ->orWhere('liked_2', 1)
            ->pluck('user_id_2');

        $match2 = Matching::where('user_id', Auth::user()->id)
            ->where('liked', 1)
            ->orWhere('liked_2', 1)
            ->pluck('user_id');

        // get all blacklisted users and get their user_id's
        $blacklist = Blacklist::where('user_id', Auth::user()->id)->pluck('user_id_2');

        // merge results from collections match and blacklist together to $ids
        $ids = $match->merge($blacklist);
        $ids = $ids->merge($match2);

        return $ids;
    }

    public function filtered()
    {
        $same = null;
        $counts = null;

        // query to select logged in user tags
        $tags = Usertags::where('user_id', Auth::user()->id)
            ->pluck('tag_id');

        $results = Usertags::whereNot('user_id', Auth::user()->id)
            ->whereIn('tag_id', $tags)
            ->distinct()
            ->pluck('user_id');

        for ($x = 0; $x < count($results); $x++)
        {
            // get user ids that share the same tag interests that are fetched from the current user id
            $same[] = Usertags::whereNot('user_id', Auth::user()->id)
                ->where('user_id', $results[$x])
                ->whereIn('tag_id', $tags)
                ->orderBy('user_id')
                ->pluck('user_id');

            $counts[] = count($same[$x]);
        }


        return [
            'ids' => $same,
            'counts' => $counts,
            'id' => $results
        ];

    }
}
