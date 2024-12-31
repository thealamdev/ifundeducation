<?php

namespace App\Http\Controllers\Backend;

use App\Models\FaqPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Intervention\Image\Facades\Image;

class FaqPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqPage  = FaqPage::first();
        $faqs  = Faq::orderBy( 'id', 'desc' )->get();
        return view('backend.faq_page.index', compact('faqPage', 'faqs'));
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
        $request->validate( [
            "title" => 'required|max:255',
        ] );

        $subTitle = $request->title;
        if ($request->sub_title) {
            $subTitle = $request->sub_title;
        }

        $insert = FaqPage::create( [
            'title' => $request->title,
            'sub_title' => $subTitle,
            'text_before_faq' => $request->text_before_faq,
            'text_after_faq' => $request->text_after_faq,
            'status' => 1,
        ] );

        if ( $insert ) {
            return back()->with( 'success', 'FAQ Page Insert Successful!' );
        } else {
            return back()->with( 'error', 'FAQ Page Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FaqPage  $faqPage
     * @return \Illuminate\Http\Response
     */
    public function show(FaqPage $faqPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FaqPage  $faqPage
     * @return \Illuminate\Http\Response
     */
    public function edit(FaqPage $faqPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FaqPage  $faqPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FaqPage $faqPage)
    {
        if ($request->image) {

            $request->validate( [
                "image" => 'nullable|mimes:png,jpg,jpeg',
            ] );

            $image_name = null;
            $image = $request->file('image');

            if ($image) {
                #region -- imgFilePath
                $imgFilePath = realpath(public_path('frontend/images'));
                // return $imgFilePath;
                if (!file_exists($imgFilePath))
                {
                    mkdir($imgFilePath,0777,true);
                }
                $imgFilePath .= '/pages';
                if (!file_exists($imgFilePath))
                {
                    mkdir($imgFilePath,0777,true);
                }
                #endregion

                $image_name = $faqPage->slug.'.'.$image->extension();

                #region -- image
                $tmpImg = Image::make($image);
                $tmpImg->save($imgFilePath.'/'.$image_name);
                #endregion

                $faqPage->update( [
                    'image' => $image_name,
                ] );
            }
        }

        $subTitle = $faqPage->title;
        if ($request->sub_title) {
            $subTitle = $request->sub_title;
        }
        $faqPage->update( [
            'sub_title' => $subTitle,
            'text_before_faq' => $request->text_before_faq,
            'text_after_faq' => $request->text_after_faq,
        ] );

        if ( $faqPage ) {
            return back()->with( 'success', 'FAQ Page Update Successful!' );
        }
    }

    public function imageDelete(FaqPage $faqPage)
    {
        $imgFilePath = realpath(public_path('frontend/images'));
        if (file_exists($imgFilePath))
        {
            $imgFilePath .= '/pages';
            if (file_exists($imgFilePath))
            {
                $imageFile = $imgFilePath.'/'.$faqPage->image;
                unlink($imageFile);
                $faqPage->update( [
                    'image' => null,
                ] );
                return back()->with( 'success', 'Image Delete Successful!' );
            } else {
                return back()->with( 'error', 'Image not found!' );
            }
        } else {
            return back()->with( 'error', 'Image not found!' );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FaqPage  $faqPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaqPage $faqPage)
    {
        //
    }
}
