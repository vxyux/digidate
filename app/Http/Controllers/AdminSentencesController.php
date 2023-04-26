<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sentences;
use Illuminate\Http\Request;

class AdminSentencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crud = Sentences::all();

        return view('admin_sentences.index')->with('crud', $crud);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_sentences.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $word = "{{";

        if(strpos($request->pickupline, $word) !== false){
            echo "Bro you are FUCKED!";
        } else{
            $line = str_replace("(name)", "{{ user->first_name }}", $request->pickupline);
        $check = Sentences::where('content', $request->pickupline)->first();

        if($check == NULL) {
            Sentences::create([
                'content'   => $line
            ]);

            return redirect('admin_sentences');
        }

        return redirect()->back()->with('error', 'That line already exists');
        }

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
    public function edit(Request $request, $id)
    {
        $crud = Sentences::select('id', 'content')
            ->where('id', $id)
            ->get();

        return view('admin_sentences.edit')->with('crud', $crud);
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
        $word = "{{";

        if(strpos($request->pickupline, $word) !== false){
            echo "Bro you are FUCKED!";
        } else {
            $line = str_replace("(name)", "{{ user->first_name }}", $request->pickupline);

            Sentences::where('id', $id)
                ->update([
                    'content' => $line,
                ]);
            return redirect()->route("admin_sentences.index");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sentences = sentences::where('id', $id)->first();

        $sentences->delete();

        return redirect('admin_sentences')->with('success', "You have deleted a sentence! Next time just don't make a bad one (;");

    }
}
