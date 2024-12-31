<?php

namespace App\Http\Controllers\Backend;

use App\Models\HomePageBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class HomePageBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homePageBanner  = HomePageBanner::orderBy( 'id', 'desc' )->get();
        return view('backend.home_page_banner.index', compact('homePageBanner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.home_page_banner.create');
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
            "image" => 'required|mimes:png,jpg,jpeg',
        ] );

        $image_name = 'blank';
        $image = $request->file('image');

        $insert = HomePageBanner::create( [
            'image' => $image_name,
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'status' => $request->status,
        ] );
        if ( $insert ) {

            if ($image) {
                #region -- imgFilePath
                $imgFilePath = realpath(public_path('frontend/images'));
                // return $imgFilePath;
                if (!file_exists($imgFilePath))
                {
                    mkdir($imgFilePath,0777,true);
                }
                $imgFilePath .= '/home_page_banner';
                if (!file_exists($imgFilePath))
                {
                    mkdir($imgFilePath,0777,true);
                }
                #endregion

                $image_name = 'banner_'.$insert->id.'.'.$image->extension();

                #region -- image
                $tmpImg = Image::make($image);
                $tmpImg->save($imgFilePath.'/'.$image_name);
                #endregion

                $insert->update([
                    "image" => $image_name
                ]);
            }

            return redirect(route('dashboard.page-options.home-page-banner.index'))->with('success', 'Home Page Banner Insert Successful!');
        } else {
            return back()->with( 'error', 'Home Page Banner Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomePageBanner  $homePageBanner
     * @return \Illuminate\Http\Response
     */
    public function show(HomePageBanner $homePageBanner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomePageBanner  $homePageBanner
     * @return \Illuminate\Http\Response
     */
    public function edit(HomePageBanner $homePageBanner)
    {
        return view('backend.home_page_banner.edit', compact('homePageBanner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomePageBanner  $homePageBanner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomePageBanner $homePageBanner)
    {
        if ( $request->image) {

            $request->validate( [
                "image" => 'required|mimes:png,jpg,jpeg',
            ] );

            $image_name = $homePageBanner->image;
            $image = $request->file('image');

            if ($image) {
                #region -- imgFilePath
                $imgFilePath = realpath(public_path('frontend/images'));
                // return $imgFilePath;
                if (!file_exists($imgFilePath))
                {
                    mkdir($imgFilePath,0777,true);
                }
                $imgFilePath .= '/home_page_banner';
                if (!file_exists($imgFilePath))
                {
                    mkdir($imgFilePath,0777,true);
                }
                #endregion

                $image_name = 'banner_'.$homePageBanner->id.'.'.$image->extension();

                #region -- image
                $tmpImg = Image::make($image);
                $tmpImg->save($imgFilePath.'/'.$image_name);
                #endregion

                $homePageBanner->update( [
                    'image' => $image_name,
                ] );
            }
        }

        $homePageBanner->update( [
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'status' => $request->status,
        ] );
        if ( $homePageBanner ) {
            return redirect(route('dashboard.page-options.home-page-banner.index'))->with('success', 'Home Page Banner Update Successful!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomePageBanner  $homePageBanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomePageBanner $homePageBanner)
    {
        $imgFilePath = realpath(public_path('frontend/images'));
        if (file_exists($imgFilePath))
        {
            $imgFilePath .= '/home_page_banner';
            if (file_exists($imgFilePath))
            {
                $imageFile = $imgFilePath.'/'.$homePageBanner->image;
                unlink($imageFile);
            }
        }

        $homePageBanner->delete();
        return back()->with('success', 'Home Page Banner Delete Successful!');
    }
}
