<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Chat;
use App\Models\Image;
use App\Models\Matching;
use App\Models\QrManager;
use App\Models\Usertags;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Tags;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use mysql_xdevapi\Exception;


class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $gender = User::select('gender')
            ->Where('id', Auth::user()->id)
            ->get();

        $userInfo = User::select('orientation', 'image')
            ->join('images', 'users.images_id', '=', 'images.id')
            ->Where('users.id', Auth::user()->id)
            ->get();

        $has_2fa = QrManager::where('id', Auth::user()->qr_id)->pluck('google2fa_enable')->first();

        $tags = Tags::select('id', 'name')
            ->get();

        $selected = Usertags::select('tag_id')
            ->Where('user_id', Auth::user()->id)
            ->get();

        return view('profile.edit', [
            'tags' => $tags,
            'selected' => $selected,
            'gender' => $gender,
            'userInfo' => $userInfo,
            'user' => $request->user(),
            'has_2fa' => $has_2fa
        ]);

    }

    /**
     * store the changes in username
     */
    public function store(Request $request)
    {

        $request->validate([
            'email' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . Auth::user()->id],
            'first_name' => ['required', 'string'],
            'infix' => ['string', 'nullable'],
            'last_name' => ['required', 'string'],
            'gender' => ['int'],
            'orientation' => ['int'],
            'address' => ['required', 'string'],
            'country' => ['required', 'string'],
            'street_nr' => ['required', 'string'],
            'zipcode' => ['required', 'regex:/^[0-9]{4}[A-Z]{2}$/'],
            'description' => ['nullable', 'max:100'],
            'tags' => ['required_without_all']
        ],
            $messages = [
                'tags.required_without_all' => 'You must select at least one tag.',
            ]);

        if (file_exists('storage/media/' . Auth::user()->username . 'storage/media/' . $request['username'])) {
            rename('storage/media/' . Auth::user()->username, 'storage/media/' . $request['username']);
        }

        if (count($request->tags) <= 5) {
            try {
                User::where('id', Auth::user()->id)
                    ->update([
                        'username' => $request["username"],
                        'first_name' => $request["first_name"],
                        'infix' => $request["infix"],
                        'last_name' => $request["last_name"],
                        'gender' => $request["gender"],
                        'orientation' => $request["orientation"],
                        'phone' => $request["phone"],
                        'address' => $request["address"],
                        'country' => $request["country"],
                        'street_nr' => $request['street_nr'],
                        'zipcode' => $request['zipcode'],
                        'description' => $request["description"],
                    ]);

                Usertags::where('user_id', Auth::user()->id)->delete();

                foreach ($request['tags'] as $tag) {
                    Usertags::create([
                        'user_id' => Auth::user()->id,
                        'tag_id' => $tag,
                    ]);
                }
            } catch (\Exception $e) {
                echo($e);

                if (!file_exists('storage/media/' . Auth::user()->username . 'storage/media/' . $request['username'])) {
                    rename('storage/media/' . Auth::user()->username, 'storage/media/' . $request['username']);
                }

                return redirect()->route('profile.edit')->with('success', 'Your profile has successfully been updated!');
            }
        }
        else
            {
                return redirect()->route('profile.edit')->with('error', 'You can not have more than 5 total tags.');
            }
        return redirect()->route('profile.edit')->with('success', 'Your profile has successfully been updated!');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function image(Request $request)
    {
        if (file_exists('storage/media/' . Auth::user()->username)) {
            Storage::deleteDirectory('public/media/' . Auth::user()->username);

            $old = image::where('id', Auth::user()->images_id)->first();

            $update = Auth::user()->update(['images_id' => '1']);

            $old->delete();
        }



        if ($request->hasFile('image')) {
            $request->image->store('media/' . Auth::user()->username . '/profilePicture/', 'public');
        }

        $insertImage = Image::create(['image' => $request->image->hashname()]);

        if ($request->hasFile('images')) {
            foreach ($request->images as $i => $image) {
                $image->store('media/' . Auth::user()->username . '/secondaryPictures/', 'public');
                Image::where('id', $insertImage->id)->update(['image_' . $i + 2 => $image->hashname()]);
            }
        }
        Auth::user()->update(['images_id' => $insertImage->id]);

        /* Store $imageName name in DATABASE from HERE */

        return back()
            ->with('correct', 'your images is up to date.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            //gets the imageid from the loggedin user
            $imageId = Auth::user()->images_id;
            //deletes the matches from the database where user_id or user_id-2 is the users id
            Matching::where('user_id', Auth::user()->id)->orWhere('user_id_2', Auth::user()->id)->delete();
            //deletes the images from the directory
            Storage::deleteDirectory('public/media/' . Auth::user()->username);
            //force deletes the user from database instead of solft delete
            Auth::user()->forceDelete();
            //deletes the images from the database
            Image::where('id', $imageId)->delete();
            //deletes all sessions
            Session::flush();
            //makes sure the user logsout when deleted
            Auth::logout();
        }catch (Exception $e){

        }
        return Redirect::to('/');
    }
}
