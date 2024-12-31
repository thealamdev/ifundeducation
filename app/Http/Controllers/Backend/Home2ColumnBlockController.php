<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IconTextBox2Col;
use Illuminate\Http\Request;

class Home2ColumnBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home2ColumnBlocks  = IconTextBox2Col::orderBy( 'id', 'desc' )->get();
        return view('backend.home_2_column_block.index', compact('home2ColumnBlocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.home_2_column_block.create');
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

        $insert = IconTextBox2Col::create( [
            'icon' => $request->icon,
            'title' => $request->title,
            'description' => $request->description,
        ] );

        if ( $insert ) {
            return redirect(route('dashboard.page-options.home-2-column-block.index'))->with('success', 'Home 2 Column Block Insert Successful!');
        } else {
            return back()->with( 'error', 'Home 2 Column Block Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IconTextBox2Col  $iconTextBox2Col
     * @return \Illuminate\Http\Response
     */
    public function show(IconTextBox2Col $iconTextBox2Col)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IconTextBox  $iconTextBox
     * @return \Illuminate\Http\Response
     */
    public function edit(IconTextBox2Col $iconTextBox2Col)
    {
        return view('backend.home_2_column_block.edit', compact('iconTextBox2Col'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IconTextBox2Col  $iconTextBox2Col
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IconTextBox2Col $iconTextBox2Col)
    {
        $request->validate( [
            "title" => 'required|max:255',
        ] );

        $iconTextBox2Col->update( [
            'icon' => $request->icon,
            'title' => $request->title,
            'description' => $request->description,
        ] );

        if ( $iconTextBox2Col ) {
            return redirect(route('dashboard.page-options.home-2-column-block.index'))->with('success', 'Home 2 Column Block Update Successful!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IconTextBox2Col  $iconTextBox2Col
     * @return \Illuminate\Http\Response
     */
    public function destroy(IconTextBox2Col $iconTextBox2Col)
    {
        //
    }
}
