<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravolt\Avatar\Avatar;
use Yajra\DataTables\Facades\DataTables;

class WishlistController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $wishlists = Wishlist::with('fundraiser_post:id,title')->where('user_id', auth()->user()->id)->get();
        return view('frontend.wishlist.index', compact('wishlists'));
    }

    public function listDataTable(Request $request, Avatar $av) {
        $wishlists = Wishlist::with('fundraiser_post:id,title,slug,image')->where('user_id', auth()->user()->id);

        if ($request->all()) {
            $wishlists->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('fundraiser_post_id', '=', $request->title);
                }
                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('created_at', '<=', $to_date);
                }
            });
        }

        return DataTables::of($wishlists)

            ->editColumn('title', function ($wishlists) {
                return $wishlists->fundraiser_post->title;
            })
            ->editColumn('image', function ($wishlists) use ($av) {
                if ($wishlists->fundraiser_post->image) {

                    return '<img src="' . asset('storage/fundraiser_post/' . $wishlists->fundraiser_post->image) . '"
                                            alt="' . $wishlists->fundraiser_post->title . '" width="80">';
                } else {
                    return '<img src="' . $av->create($wishlists->fundraiser_post->title)->setShape('square')->setBackground('#ddd')->setDimension(80)->setFontSize(14)->toBase64() . '"
                                            alt="' . $wishlists->fundraiser_post->title . '">';
                }
            })

            ->editColumn('created_at', function ($wishlists) {
                return $wishlists->created_at->format('M d, Y');
            })
            ->addColumn('action', function ($wishlists) {
                return '<div class="text-end">
                    <a href="' . route('front.fundraiser.post.show', $wishlists->fundraiser_post->slug) . '"
                                        class="action_icon" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                        <form action="' . route('wishlist.destroy', $wishlists->id) . '" method="POST"
                            class="d-inline" style="cursor: pointer">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <p class="action_icon delete post_delete" title="Delete">
                                <i class="fas fa-trash"></i>
                            </p>
                        </form>
                </div>';
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error', "Somthing Wrong!");
        }

        $data = Wishlist::updateOrCreate([
            'fundraiser_post_id' => $request->post_id,
        ], [
            'user_id'            => auth()->user()->id,
            'fundraiser_post_id' => $request->post_id,
        ]);

        if ($data) {
            return back()->with('success', 'Added Wishlist Successfully!');
        } else {
            return back()->with('error', 'Wishlist Not Added!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist) {
        $wishlist->delete();
        return back()->with('success', 'Wishlist Delete Successfull!');
    }
}