<?php

namespace App\Http\Controllers;

use App\Models\NewPost;
use Illuminate\Http\Request;

class NewPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.newpost');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewPost  $newPost
     * @return \Illuminate\Http\Response
     */
    public function show(NewPost $newPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewPost  $newPost
     * @return \Illuminate\Http\Response
     */
    public function edit(NewPost $newPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewPost  $newPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewPost $newPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewPost  $newPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewPost $newPost)
    {
        //
    }
}
