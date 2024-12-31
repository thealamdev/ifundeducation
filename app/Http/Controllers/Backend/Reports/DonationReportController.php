<?php

namespace App\Http\Controllers\Backend\Reports;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Models\Donate;
use App\Models\FundraiserPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DonationReportController extends Controller {
    public function index() {

        $campaigns = FundraiserPost::whereIn('status', ['running', 'block', 'completed'])
            ->get(['id', 'title', 'user_id']);

        $hasCampaign = $campaigns->pluck('user_id')->toArray();
        $fundraisers = User::whereIn('id', $hasCampaign)->get(['id', 'first_name', 'last_name', 'email']);

        return view('backend.reports.donation.index', compact('campaigns', 'fundraisers'));
    }

    public function listDatatable(Request $request) {

        $donations = Donate::with(['campaign:id,title,slug,user_id', 'campaign.user:id,first_name,last_name,email'])
            ->join('fundraiser_posts', 'fundraiser_posts.id', 'donates.fundraiser_post_id')
            ->select('donates.*', 'fundraiser_posts.user_id');

        if ($request->all()) {
            $donations->where(function ($query) use ($request) {
                if ($request->user) {
                    $query->where('user_id', '=', $request->user);
                }
                if ($request->title) {
                    $query->where('donates.fundraiser_post_id', '=', $request->title);
                }
                if ($request->status) {
                    $query->where('donates.status', '=', $request->status);
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

        return DataTables::of($donations)

            ->addColumn('author', function ($donations) {
                return $donations->campaign->user->first_name . ' ' . $donations->campaign->user->last_name . "<br>" . $donations->campaign->user->email;

            })
            ->editColumn('campaign', function ($donations) {
                return '<a href="' . route('dashboard.fundraiser.campaign.campaign.show', $donations->campaign->slug) . '" target="_blank" title="' . $donations->campaign->title . '">' . Str::limit($donations->campaign->title, 20, '...') . '</a>';
            })
            ->editColumn('created_at', function ($donations) {
                return $donations->created_at->format('M d, Y');
            })
            ->editColumn('amount', function ($donations) {
                return '$' . number_format($donations->amount, 2);
            })
            ->editColumn('stripe_fee', function ($donations) {
                return '$' . number_format($donations->stripe_fee, 2);
            })
            ->editColumn('platform_fee', function ($donations) {
                return '$' . number_format($donations->platform_fee, 2);
            })
            ->editColumn('net_balance', function ($donations) {
                return '$' . number_format($donations->net_balance, 2);
            })
            ->editColumn('donar', function ($donations) {
                $donor = $donations->donar_name ?? 'Guest';
                return $donor . '<br>' . $donations->donar_email ?? '--';
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function exportExcel(Request $request) {
        $donations = Donate::query()
            ->join('fundraiser_posts', 'fundraiser_posts.id', 'donates.fundraiser_post_id')
            ->select('donates.*', 'fundraiser_posts.user_id');

        if ($request->all()) {
            $donations->where(function ($query) use ($request) {
                if ($request->user_id) {
                    $query->where('user_id', '=', $request->user_id);
                }
                if ($request->campaign_id) {
                    $query->where('fundraiser_post_id', '=', $request->campaign_id);
                }
                if ($request->from_date) {
                    $from_date = date("Y-m-d", strtotime($request->from_date));
                    $query->where('donates.created_at', '>=', $from_date);
                }
                if ($request->to_date) {
                    $to_date = date("Y-m-d", strtotime($request->to_date));
                    $query->where('donates.created_at', '<=', $to_date);
                }
            });
        }

        $donation = $donations->with(['campaign:id,title,slug,user_id', 'campaign.user:id,first_name,last_name,email'])->get();

        $view_link = 'backend.reports.donation.excel_export';
        $file_name = "donation_list_" . time() . '.xlsx';
        $data      = [
            "donations" => $donation,
        ];
        return Excel::download(new MisReportExport($data, $view_link), $file_name);
    }

}
