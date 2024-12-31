<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IconTextBox;
use Illuminate\Http\Request;

class Home3ColumnBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home3ColumnBlocks  = IconTextBox::orderBy( 'id', 'desc' )->get();
        return view('backend.home_3_column_block.index', compact('home3ColumnBlocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.home_3_column_block.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate( [
            "title" => 'required|max:255',
        ] );

        $insert = IconTextBox::create( [
            'icon' => $request->icon,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'link' => $request->link,
            'status' => $request->status,
        ] );

        if ( $insert ) {
            return redirect(route('dashboard.page-options.home-3-column-block.index'))->with('success', 'Home 3 Column Block Insert Successful!');
        } else {
            return back()->with( 'error', 'Home 3 Column Block Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IconTextBox  $iconTextBox
     * @return \Illuminate\Http\Response
     */
    public function show(IconTextBox $iconTextBox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IconTextBox  $iconTextBox
     * @return \Illuminate\Http\Response
     */
    public function edit(IconTextBox $iconTextBox)
    {
        return view('backend.home_3_column_block.edit', compact('iconTextBox'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IconTextBox  $iconTextBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IconTextBox $iconTextBox)
    {
        $request->validate( [
            "title" => 'required|max:255',
        ] );

        $iconTextBox->update( [
            'icon' => $request->icon,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'link' => $request->link,
            'status' => $request->status,
        ] );

        if ( $iconTextBox ) {
            return redirect(route('dashboard.page-options.home-3-column-block.index'))->with('success', 'Home 3 Column Block Update Successful!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IconTextBox  $iconTextBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(IconTextBox $iconTextBox)
    {
        //
    }
}
