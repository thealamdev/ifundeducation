<?php

namespace App\Http\Controllers\Backend;

use App\Models\ContactPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ContactPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactPage  = ContactPage::first();
        return view('backend.contact_page.index', compact('contactPage'));
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

        $insert = ContactPage::create( [
            'title' => $request->title,
            'sub_title' => $subTitle,
            'address_icon' => $request->address_icon,
            'address_title' => $request->address_title,
            'address_text' => $request->address_text,
            'email_icon' => $request->email_icon,
            'email_title' => $request->email_title,
            'email_text' => $request->email_text,
            'phone_icon' => $request->phone_icon,
            'phone_title' => $request->phone_title,
            'phone_text' => $request->phone_text,
            'status' => 1,
        ] );

        if ( $insert ) {
            return back()->with( 'success', 'Contact Page Insert Successful!' );
        } else {
            return back()->with( 'error', 'Contact Page Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactPage  $contactPage
     * @return \Illuminate\Http\Response
     */
    public function show(ContactPage $contactPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactPage  $contactPage
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactPage $contactPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactPage  $contactPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactPage $contactPage)
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

                $image_name = $contactPage->slug.'.'.$image->extension();

                #region -- image
                $tmpImg = Image::make($image);
                $tmpImg->save($imgFilePath.'/'.$image_name);
                #endregion

                $contactPage->update( [
                    'image' => $image_name,
                ] );
            }
        }

        $subTitle = $contactPage->title;
        if ($request->sub_title) {
            $subTitle = $request->sub_title;
        }

        $contactPage->update( [
            'sub_title' => $subTitle,
            'address_icon' => $request->address_icon,
            'address_title' => $request->address_title,
            'address_text' => $request->address_text,
            'email_icon' => $request->email_icon,
            'email_title' => $request->email_title,
            'email_text' => $request->email_text,
            'phone_icon' => $request->phone_icon,
            'phone_title' => $request->phone_title,
            'phone_text' => $request->phone_text,
            'status' => 1,
        ] );

        if ( $contactPage ) {
            return back()->with( 'success', 'Contact Page Update Successful!' );
        }
    }

    public function imageDelete(ContactPage $contactPage)
    {
        $imgFilePath = realpath(public_path('frontend/images'));
        if (file_exists($imgFilePath))
        {
            $imgFilePath .= '/pages';
            if (file_exists($imgFilePath))
            {
                $imageFile = $imgFilePath.'/'.$contactPage->image;
                unlink($imageFile);
                $contactPage->update( [
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
     * @param  \App\Models\ContactPage  $contactPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactPage $contactPage)
    {
        //
    }
}
