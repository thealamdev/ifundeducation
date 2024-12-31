<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Donate;
use App\Models\FundraiserPost;
use App\Models\ThemeOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class DonorController extends Controller {

    public function donateList() {
        $fundposts = FundraiserPost::join('donates', 'donates.fundraiser_post_id', 'fundraiser_posts.id')
            ->select('fundraiser_posts.id', DB::raw('MAX(fundraiser_posts.title) as title'))
            ->where('donar_id', Auth::id())->groupBy('fundraiser_posts.id')->get();

        return view('frontend.donor.index', compact('fundposts'));
    }

    public function listDataTabel(Request $request) {
        $all_donates = Donate::join('fundraiser_posts', 'fundraiser_posts.id', 'donates.fundraiser_post_id')
            ->select('donates.*', 'fundraiser_posts.title', 'fundraiser_posts.slug', 'fundraiser_posts.user_id')
            ->where('donar_id', Auth::id());

        if ($request->all()) {
            $all_donates->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('donates.fundraiser_post_id', '=', $request->title);
                }

                if ($request->fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->fromdate));
                    $query->where('donates.created_at', '>=', $from_date);
                }
                if ($request->todate) {
                    $to_date = date("Y-m-d", strtotime($request->todate));
                    $query->where('donates.created_at', '<=', $to_date);
                }
            });
        }

        return DataTables::of($all_donates)

            ->editColumn('title', function ($all_donates) {
                $title = '<a href="' . route('front.fundraiser.post.show', $all_donates->slug) . '">' . $all_donates->title . '</a>';
                return $title;
            })
            ->editColumn('amount', function ($all_donates) {
                return '$' . number_format($all_donates->amount, 2);
            })
            ->editColumn('created_at', function ($all_donates) {
                return $all_donates->created_at->format('M d, Y');
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function downloadDonateList(Request $request) {
        $themeOption = ThemeOption::first();

        $all_donates = Donate::join('fundraiser_posts', 'fundraiser_posts.id', 'donates.fundraiser_post_id')
            ->select('donates.*', 'fundraiser_posts.title')
            ->where('donar_id', Auth::id());

        if ($request->all()) {
            $all_donates->where(function ($query) use ($request) {
                if ($request->pdf_title) {
                    $query->where('donates.fundraiser_post_id', '=', $request->pdf_title);
                }

                if ($request->pdf_fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->pdf_fromdate));
                    $query->where('donates.created_at', '>=', $from_date);
                }
                if ($request->pdf_todate) {
                    $to_date = date("Y-m-d", strtotime($request->pdf_todate));
                    $query->where('donates.created_at', '<=', $to_date);
                }
            });
        }

        $all_donates = $all_donates->get();
        // return $campaigns;
        if ($all_donates->isEmpty()) {
            return back()->with('warning', 'Payout history not found!');
        }

        $table_columns = [];
        if ($request->donor_id_column) {
            array_push($table_columns, 'donor_id_column');
        }
        if ($request->amount_column) {
            array_push($table_columns, 'amount_column');
        }
        if ($request->date_column) {
            array_push($table_columns, 'date_column');
        }
        if ($request->campaign_title_column) {
            array_push($table_columns, 'campaign_title_column');
        }

        // return $table_columns;

        $data = [
            'all_donates'  => $all_donates,
            'themeOption'  => $themeOption,
            'table_column' => $table_columns,
        ];
        $pdf = PDF::loadView('pdf.frontend.donor_donatepdf', $data);
        $pdf->download('donate.pdf');
        return back();
    }
}
