<?php

namespace App\Http\Controllers\Backend;

use App\Models\CommonPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class CommonPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commonPages  = CommonPage::orderBy( 'id', 'desc' )->get();
        return view('backend.common_page.index', compact('commonPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.common_page.create');
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

        $insert = CommonPage::create( [
            'title' => $request->title,
            'sub_title' => $subTitle,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'status' => 1,
        ] );

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

                $image_name = $insert->slug.'.'.$image->extension();

                #region -- image
                $tmpImg = Image::make($image);
                $tmpImg->save($imgFilePath.'/'.$image_name);
                #endregion

                $insert->update( [
                    'image' => $image_name,
                ] );
            }
        }

        if ( $insert ) {
            return redirect()->route('dashboard.pages.all-pages.index')->with( 'success', 'Page Insert Successful!' );
        } else {
            return back()->with( 'error', 'Page Insert Error!' );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommonPage  $commonPage
     * @return \Illuminate\Http\Response
     */
    public function show(CommonPage $commonPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommonPage  $commonPage
     * @return \Illuminate\Http\Response
     */
    public function edit(CommonPage $commonPage, $slug)
    {
        $commonPage  = CommonPage::firstWhere('slug', $slug);
        return view('backend.common_page.edit', compact('commonPage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommonPage  $commonPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommonPage $commonPage)
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

                $image_name = $commonPage->slug.'.'.$image->extension();

                #region -- image
                $tmpImg = Image::make($image);
                $tmpImg->save($imgFilePath.'/'.$image_name);
                #endregion

                $commonPage->update( [
                    'image' => $image_name,
                ] );
            }
        }

        $subTitle = $commonPage->title;
        if ($request->sub_title) {
            $subTitle = $request->sub_title;
        }

        $commonPage->update( [
            'sub_title' => $subTitle,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'status' => 1,
        ] );

        if ( $commonPage ) {
            return redirect()->route('dashboard.pages.all-pages.index')->with( 'success', $commonPage->title.' Page Update Successful!' );
        }
    }

    public function imageDelete(CommonPage $commonPage)
    {
        $imgFilePath = realpath(public_path('frontend/images'));
        if (file_exists($imgFilePath))
        {
            $imgFilePath .= '/pages';
            if (file_exists($imgFilePath))
            {
                $imageFile = $imgFilePath.'/'.$commonPage->image;
                unlink($imageFile);
                $commonPage->update( [
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
     * @param  \App\Models\CommonPage  $commonPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommonPage $commonPage)
    {
        //
    }
}
