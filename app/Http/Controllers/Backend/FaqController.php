<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = Faq::create( [
            'question' => $request->question,
            'answer' => $request->answer,
            'note' => $request->note,
            'status' => 1,
        ] );

        if ( $insert ) {
            return redirect(route('dashboard.pages.faq-page.index'))->with( 'success', 'FAQ Insert Successful! [ID: '.$insert->id.']' );
        } else {
            return back()->with( 'error', 'FAQ Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('backend.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $faq->update( [
            'question' => $request->question,
            'answer' => $request->answer,
            'note' => $request->note,
            'status' => $request->status,
        ] );

        if ( $faq ) {
            return redirect(route('dashboard.pages.faq-page.index'))->with( 'success', 'FAQ Update Successful! [ID: '.$faq->id.']' );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with( 'success', 'FAQ Delete Successful! [ID: '.$faq->id.']' );
    }
}
