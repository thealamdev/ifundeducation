<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FooterMenu;
use Illuminate\Http\Request;

class FooterMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $footerMenus  = FooterMenu::orderBy( 'id', 'desc' )->get();
        return view('backend.footer_menu.index', compact('footerMenus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.footer_menu.create');
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
            "name" => 'required|max:100',
        ] );

        $insert = FooterMenu::create( [
            'name' => $request->name,
            'link' => $request->link,
            'status' => $request->status,
        ] );

        if ( $insert ) {
            return redirect(route('dashboard.page-options.footer-menu.index'))->with( 'success', 'Footer Menu Insert Successful!' );
        } else {
            return back()->with( 'error', 'Footer Menu Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FooterMenu  $footerMenu
     * @return \Illuminate\Http\Response
     */
    public function show(FooterMenu $footerMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FooterMenu  $footerMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(FooterMenu $footerMenu)
    {
        return view('backend.footer_menu.edit', compact('footerMenu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FooterMenu  $footerMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FooterMenu $footerMenu)
    {
        $request->validate( [
            "name" => 'required|max:100',
        ] );

        $footerMenu->update( [
            'name' => $request->name,
            'link' => $request->link,
            'status' => $request->status,
        ] );

        if ( $footerMenu ) {
            return redirect(route('dashboard.page-options.footer-menu.index'))->with( 'success', 'Footer Menu Update Successful!' );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FooterMenu  $footerMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(FooterMenu $footerMenu)
    {
        $footerMenu->delete();
        return redirect(route('dashboard.page-options.footer-menu.index'))->with( 'success', 'Footer Menu ('.$footerMenu->name.') Delete Successful!' );
    }
}
