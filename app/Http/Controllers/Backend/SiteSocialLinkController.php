<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSocialLink;
use Illuminate\Http\Request;

class SiteSocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siteSocialLinks  = SiteSocialLink::orderBy( 'id', 'desc' )->get();
        return view('backend.site_social_link.index', compact('siteSocialLinks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.site_social_link.create');
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
            "icon" => 'required|max:150',
            "name" => 'required|max:150',
        ] );

        $insert = SiteSocialLink::create( [
            'name' => $request->name,
            'link' => $request->link,
            'icon' => $request->icon,
            'status' => 1,
        ] );

        if ( $insert ) {
            return redirect(route('dashboard.page-options.site-social-links.index'))->with( 'success', 'Social Link Insert Successful!' );
        } else {
            return back()->with( 'error', 'Social Link Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SiteSocialLink  $siteSocialLink
     * @return \Illuminate\Http\Response
     */
    public function show(SiteSocialLink $siteSocialLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SiteSocialLink  $siteSocialLink
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSocialLink $siteSocialLink)
    {
        return view('backend.site_social_link.edit', compact('siteSocialLink'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteSocialLink  $siteSocialLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteSocialLink $siteSocialLink)
    {
        $request->validate( [
            "icon" => 'required|max:150',
            "name" => 'required|max:150',
        ] );

        $siteSocialLink->update( [
            'name' => $request->name,
            'link' => $request->link,
            'icon' => $request->icon,
            'status' => $request->status,
        ] );

        if ( $siteSocialLink ) {
            return redirect(route('dashboard.page-options.site-social-links.index'))->with( 'success', 'Social Link Update Successful!' );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SiteSocialLink  $siteSocialLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSocialLink $siteSocialLink)
    {
        $siteSocialLink->delete();
        return redirect(route('dashboard.page-options.site-social-links.index'))->with( 'success', 'Social Link ('.$siteSocialLink->name.') Delete Successful!' );
    }
}
