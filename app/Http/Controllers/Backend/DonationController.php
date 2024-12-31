<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Donate;
use App\Models\FundraiserPost;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DonationController extends Controller {

    public function index() {
        $fundposts = FundraiserPost::select('id', 'title')
            ->whereIn('status', ['running', 'completed', 'block'])
            ->get();

        return view('backend.donation.index', compact('fundposts'));
    }

    public function listDatatable(Request $request) {
        $donates = Donate::join('fundraiser_posts', 'fundraiser_posts.id', 'donates.fundraiser_post_id')
            ->select('donates.*', 'fundraiser_posts.title', 'fundraiser_posts.slug', 'fundraiser_posts.user_id')
            ->orderBy('id', 'desc');

        if ($request->all()) {
            $donates->where(function ($query) use ($request) {
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

        return DataTables::of($donates)

            ->addColumn('donor', function ($donates) {
                return $donates->donar_name ? $donates->donar_name : 'Guest';

            })
            ->editColumn('amount', function ($donates) {
                return '$' . number_format($donates->amount, 2);
            })
            ->editColumn('admin_view', function ($donates) {
                return $donates->admin_view == 0 ? 'unread' : 'read';
            })
            ->editColumn('created_at', function ($donates) {
                return $donates->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($donates) {
                $links = '';

                $links .= '<a href="' . route('dashboard.campaign.donation.admin.donation.show', $donates->id) . '"
                class="btn btn-sm btn-primary" title="View">
                View
            </a>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function show($id) {
        $donation = Donate::with('fundraiser:id,title,slug')->find($id);
        if ($donation->admin_view == 0) {
            $donation->update([
                'admin_view' => 1,
            ]);
        }
        return view('backend.donation.show', compact('donation'));
    }

}
