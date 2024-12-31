<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ThemeOption;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ThemeOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $themeOption  = ThemeOption::first();
        return view('backend.theme_options.index', compact('themeOption'));
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
            "site_logo" => 'mimes:png,jpg,jpeg',
            "footer_logo" => 'mimes:png,jpg,jpeg',
        ] );

        $site_logo = $request->file('site_logo');
        $site_logo_name = 'site_logo'.'.'.$site_logo->extension();

        if ($site_logo) {
            #region -- imgFilePath
            $imgFilePath1 = realpath(public_path('frontend/images'));
            // return $imgFilePath;
            if (!file_exists($imgFilePath1))
            {
                mkdir($imgFilePath1,0777,true);
            }
            $imgFilePath1 .= '/theme_options';
            if (!file_exists($imgFilePath1))
            {
                mkdir($imgFilePath1,0777,true);
            }
            #endregion

            #region -- image
            $tmpImg1 = Image::make($site_logo);
            $tmpImg1->save($imgFilePath1.'/'.$site_logo_name);
            #endregion
        }

        $footer_logo = $request->file('footer_logo');
        $footer_logo_name = 'footer_logo'.'.'.$footer_logo->extension();

        if ($footer_logo) {
            #region -- imgFilePath
            $imgFilePath2 = realpath(public_path('frontend/images'));
            // return $imgFilePath;
            if (!file_exists($imgFilePath2))
            {
                mkdir($imgFilePath2,0777,true);
            }
            $imgFilePath2 .= '/theme_options';
            if (!file_exists($imgFilePath2))
            {
                mkdir($imgFilePath2,0777,true);
            }
            #endregion

            #region -- image
            $tmpImg2 = Image::make($footer_logo);
            $tmpImg2->save($imgFilePath2.'/'.$footer_logo_name);
            #endregion
        }

        $insert = ThemeOption::create( [
            'header_email' => $request->header_email,
            'header_phone' => $request->header_phone,
            'site_logo' => $site_logo_name,
            'footer_logo' => $footer_logo_name,
            'footer_about_title' => $request->footer_about_title,
            'footer_about_description' => $request->footer_about_description,
            'footer_email' => $request->footer_email,
            'footer_phone' => $request->footer_phone,
            'footer_web_address' => $request->footer_web_address,
            'footer_web_address_link' => $request->footer_web_address_link,
            'copyright_text' => $request->copyright_text,
        ] );

        if ( $insert ) {
            return back()->with( 'success', 'Theme Options Insert Successfull!' );
        } else {
            return back()->with( 'error', 'Theme Options Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThemeOption  $themeOption
     * @return \Illuminate\Http\Response
     */
    public function show(ThemeOption $themeOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThemeOption  $themeOption
     * @return \Illuminate\Http\Response
     */
    public function edit(ThemeOption $themeOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThemeOption  $themeOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThemeOption $themeOption)
    {
        $themeOption = ThemeOption::first();

        $request->validate( [
            "site_logo" => 'mimes:png,jpg,jpeg',
            "footer_logo" => 'mimes:png,jpg,jpeg',
        ] );

        $site_logo_name = null;
        $site_logo = $request->file('site_logo');
        if ( $request->site_logo ) {
            $site_logo_name = 'site_logo'.'.'.$site_logo->extension();
        }

        if ($site_logo) {
            #region -- imgFilePath
            $imgFilePath1 = realpath(public_path('frontend/images'));
            // return $imgFilePath;
            if (!file_exists($imgFilePath1))
            {
                mkdir($imgFilePath1,0777,true);
            }
            $imgFilePath1 .= '/theme_options';
            if (!file_exists($imgFilePath1))
            {
                mkdir($imgFilePath1,0777,true);
            }
            #endregion

            #region -- image
            $tmpImg1 = Image::make($site_logo);
            $tmpImg1->save($imgFilePath1.'/'.$site_logo_name);
            #endregion
        }

        $footer_logo_name = null;
        $footer_logo = $request->file('footer_logo');
        if ( $request->footer_logo ) {
            $footer_logo_name = 'footer_logo'.'.'.$footer_logo->extension();
        }

        if ($footer_logo) {
            #region -- imgFilePath
            $imgFilePath2 = realpath(public_path('frontend/images'));
            // return $imgFilePath;
            if (!file_exists($imgFilePath2))
            {
                mkdir($imgFilePath2,0777,true);
            }
            $imgFilePath2 .= '/theme_options';
            if (!file_exists($imgFilePath2))
            {
                mkdir($imgFilePath2,0777,true);
            }
            #endregion

            #region -- image
            $tmpImg2 = Image::make($footer_logo);
            $tmpImg2->save($imgFilePath2.'/'.$footer_logo_name);
            #endregion
        }

        if ( $request->site_logo ) {
            $themeOption->update( [
                'site_logo' => $site_logo_name,
            ] );
        }

        if ( $request->footer_logo ) {
            $themeOption->update( [
                'footer_logo' => $footer_logo_name,
            ] );
        }

        $themeOption->update( [
            'header_email' => $request->header_email,
            'header_phone' => $request->header_phone,
            'footer_about_title' => $request->footer_about_title,
            'footer_about_description' => $request->footer_about_description,
            'footer_email' => $request->footer_email,
            'footer_phone' => $request->footer_phone,
            'footer_web_address' => $request->footer_web_address,
            'footer_web_address_link' => $request->footer_web_address_link,
            'copyright_text' => $request->copyright_text,
        ] );

        if ( $themeOption ) {
            return back()->with( 'success', 'Theme Options Update Successfull!' );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThemeOption  $themeOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThemeOption $themeOption)
    {
        // $themeOption->delete();
        // return back()->with('success', 'Theme Options Delete Successful!');
    }
}
