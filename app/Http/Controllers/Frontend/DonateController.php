<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Donate;
use App\Models\FundraiserBalance;
use App\Models\FundraiserPost;
use App\Models\ThemeOption;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class DonateController extends Controller {

    public function index() {

        $fundposts = FundraiserPost::select('id', 'title')->where('user_id', Auth::id())->get();

        return view('frontend.donate.index', compact('fundposts'));
    }
    public function listDataTabel(Request $request) {
        $all_donars = Donate::join('fundraiser_posts', 'fundraiser_posts.id', 'donates.fundraiser_post_id')
            ->select('donates.*', 'fundraiser_posts.title', 'fundraiser_posts.user_id')
            ->where('fundraiser_posts.user_id', Auth::id());

        if ($request->all()) {
            $all_donars->where(function ($query) use ($request) {
                if ($request->title) {
                    $query->where('donates.fundraiser_post_id', '=', $request->title);
                }
                if ($request->donorname) {
                    if (Str::lower($request->donorname) === 'guest') {
                        $query->where('donates.display_publicly', 'no');
                    } else {
                        $query->where('donates.donar_name', 'like', "%$request->donorname%");
                    }
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

        return DataTables::of($all_donars)

            ->editColumn('stripe_fee', function ($all_donars) {
                return '$' . number_format($all_donars->stripe_fee, 2);
            })
            ->editColumn('net_balance', function ($all_donars) {
                return '$' . number_format($all_donars->net_balance, 2);
            })
            ->editColumn('net_balance', function ($all_donars) {
                return '$' . number_format($all_donars->net_balance, 2);
            })
            ->editColumn('created_at', function ($all_donars) {
                return $all_donars->created_at->format('M d, Y');
            })
            ->editColumn('donor', function ($all_donars) {
                return $all_donars->display_publicly === 'yes' ? $all_donars->donar_name : 'Guest';
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function downloadDonationList(Request $request) {

        // return $request;
        $themeOption = ThemeOption::first();

        $all_donars = Donate::join('fundraiser_posts', 'fundraiser_posts.id', 'donates.fundraiser_post_id')
            ->select('donates.id', 'donates.created_at', 'donates.display_publicly', 'donates.donar_name', 'donates.net_balance', 'donates.stripe_fee', 'fundraiser_posts.title', 'fundraiser_posts.user_id')
            ->where('fundraiser_posts.user_id', Auth::id());

        if ($request->all()) {
            $all_donars->where(function ($query) use ($request) {
                if ($request->pdf_title) {
                    $query->where('donates.fundraiser_post_id', '=', $request->pdf_title);
                }
                if ($request->pdf_donorname) {
                    if (Str::lower($request->pdf_donorname) === 'guest') {
                        $query->where('donates.display_publicly', 'no');
                    } else {
                        $query->where('donates.donar_name', 'like', "%$request->pdf_donorname%");
                    }
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

        $all_donars = $all_donars->get();

        if ($all_donars->isEmpty()) {
            return back()->with('warning', 'Donation not found!');
        }

        // return $all_donars;

        $table_columns = [];
        if ($request->campaign_id) {
            array_push($table_columns, 'campaign_id');
        }
        if ($request->campaign_title) {
            array_push($table_columns, 'campaign_title');
        }
        if ($request->stripe_fee) {
            array_push($table_columns, 'stripe_fee');
        }
        if ($request->amount) {
            array_push($table_columns, 'amount');
        }
        if ($request->date) {
            array_push($table_columns, 'date');
        }
        if ($request->donor) {
            array_push($table_columns, 'donor');
        }
        // return $table_columns;

        $data = [
            'all_donars'   => $all_donars,
            'themeOption'  => $themeOption,
            'table_column' => $table_columns,
        ];
        $pdf = PDF::loadView('pdf.frontend.donationpdf', $data);
        $pdf->download('campaign.pdf');
        return back();
    }

    public function create($slug) {

        $fundPost = FundraiserPost::where('slug', $slug)->select('id', 'user_id', 'slug', 'title', 'image', 'shot_description')->firstOrFail();

        if ($fundPost->status === 'completed') {
            return view('frontend.donate.completed');
        }

        $countries = Country::all();
        return view('frontend.donate.stripe', compact('fundPost', 'countries'));

    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function donatePost(Request $request) {

        $post    = FundraiserPost::find($request->post_id);
        $balance = FundraiserBalance::where('user_id', $post->user_id)->first();

        if ($post->status === 'completed') {
            return view('frontend.donate.completed');
        }

        $request->validate([
            "cardNumber"  => 'required|min:19',
            "expiraMonth" => 'required|numeric|digits_between:1,2',
            "expiraYear"  => 'required|numeric|digits:2',
            "cardCVC"     => 'required|numeric|digits:3',
            "name"        => 'required',
            "email"       => 'required|email',
            "zipCode"     => 'required|numeric',
            "country"     => 'required',
            "amount"      => 'required|integer|min:10',
        ]);

        $platformFee = ($request->amount * 3.5) / 100;

        try {
            $stripe = new \Stripe\StripeClient(config('stripe.connect.stripe_secret'));

            \Stripe\Stripe::setApiKey(config('stripe.connect.stripe_secret'));

            $token = $stripe->tokens->create([
                'card' => [
                    'number'    => $request->cardNumber,
                    'exp_month' => $request->expiraMonth,
                    'exp_year'  => $request->expiraYear,
                    'cvc'       => $request->cardCVC,
                ],
            ]);

            $customer = $stripe->customers->create([
                'source'   => $token,
                'name'     => $request->name,
                'email'    => $request->email,
                'metadata' => [
                    'zip_code' => $request->zipCode,
                    'country'  => $request->country,
                ],
            ]);

            $charge = $stripe->charges->create([
                'amount'      => round(($request->amount + $platformFee) * 100),
                'currency'    => 'usd',
                'description' => $post->title,
                'customer'    => $customer->id,
            ]);

            $transaction = $stripe->balanceTransactions->retrieve(
                $charge->balance_transaction
            );

            $platform_fee = (($transaction->net / 100) * 3.5) / 100;

            $donate = Donate::create([
                "donar_id"               => auth()->user()->id ?? null,
                'donar_name'             => $request->name,
                'donar_email'            => $request->email,
                "fundraiser_post_id"     => $request->post_id,
                "charge_id"              => $charge->id,
                "balance_transaction_id" => $transaction->id,
                "amount"                 => $transaction->amount / 100,
                "stripe_fee"             => $transaction->fee / 100,
                "net_balance"            => ($transaction->net / 100) - $platform_fee,
                "platform_fee"           => $platform_fee,
                "currency"               => 'usd',
                "display_publicly"       => $request->is_display_info === "on" ? "no" : "yes",
            ]);

            if ($balance) {
                $balance->update([
                    'total_amount' => (($transaction->net / 100) - $platform_fee) + $balance->total_amount,
                    'net_balance'  => (($transaction->net / 100) - $platform_fee) + $balance->net_balance,
                ]);
            } else {
                FundraiserBalance::create([
                    "user_id"      => Auth::id(),
                    'total_amount' => ($transaction->net / 100) - $platform_fee,
                ]);
            }

            if ($post->donates->sum('net_balance') >= $post->goal) {
                $post->update([
                    'status' => 'completed',
                ]);
            }

            return redirect()->route('front.fundraiser', $post->slug)->with('success', 'Donate Successfull');

        } catch (Exception $e) {

            return back()->with('error', $e->getMessage());
        }

    }

}