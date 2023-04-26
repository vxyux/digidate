<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sentences;
use Illuminate\Http\Request;
use App\Models\Tag;

class AdminTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();

        return view('admin_tags.index')->with('crud', $tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = Tag::where('name', $request->tagname)->first();

        if($check == NULL) {
            Tag::create([
                'name'   => $request->tagname
            ]);

            return redirect('admin_tags');
        }

        return redirect()->back()->with('error', 'Tag already exists');


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
        $crud = Tag::select('id', 'name')
            ->where('id', $id)
            ->get();

        return view('admin_tags.edit')->with('crud', $crud);

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

        Tag::where('id', $id)
            ->update([
                'name' => $request["tagname"],
            ]);
        return redirect()->route("admin_tags.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // nathan dubbel check dit even
        $tag = Tag::where('id', $id)->first();

        $tag->delete();

        return redirect('admin_tags')->with('success', "You have deleted a tag! Let's hope it wasn't a mistake");
    }
}
