<?php

namespace App\Http\Controllers;

use App\Models\FundraiserBalance;
use App\Models\Payout;
use App\Models\PayoutEmailVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Stripe\Account;
use Stripe\Balance;
use Stripe\Stripe;
use Yajra\DataTables\Facades\DataTables;

class StripeConnectController extends Controller {
    public function index() {

        $stripe = new \Stripe\StripeClient(config('stripe.connect.stripe_secret'));

        $stripeAccount = [];

        $account = $stripe->accounts->retrieve(
            auth()->user()->stripe_account_id,
            []
        );

        if ($account) {
            $stripeAccount['email']          = $account->email;
            $stripeAccount['display_name']   = $account->settings->dashboard->display_name;
            $stripeAccount['connected_date'] = date('d M Y', $account->created);
        }

        // $usersAmount = Auth::user()->load(['all_donars' => function ($q) {
        //     $q->select(DB::raw("SUM(net_balance) as balance"));
        // }]);
        $balance            = Auth::user()->load('balance');
        $payoutAttemptCount = PayoutEmailVerification::where('user_id', Auth::id())->whereDate('created_at', '=', Carbon::today()->toDateString())->orderBy('id', 'desc')->take(3)->count();

        $payoutRequest = Payout::where('user_id', Auth::id())->where('status', 'processing')->count();

        return view('withdrawals.index', compact('balance', 'stripeAccount', 'payoutAttemptCount', 'payoutRequest'));
    }

    public function listDataTable(Request $request) {
        $payoutRequestall = Payout::where('user_id', Auth::id());

        if ($request->all()) {
            $payoutRequestall->where(function ($query) use ($request) {
                if ($request->status) {
                    $query->where('status', '=', $request->status);
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

        return DataTables::of($payoutRequestall)

            ->editColumn('amount', function ($payoutRequestall) {
                return '$' . number_format($payoutRequestall->amount, 2);
            })
            ->editColumn('status', function ($payoutRequestall) {
                $status = $payoutRequestall->status == 'transfer' ? 'success' : 'warning';
                return '<span class="badge bg-' . $status . '">' . Str::ucfirst($payoutRequestall->status) . '</span>';
            })
            ->editColumn('created_at', function ($wishlists) {
                return $wishlists->created_at->format('M d, Y');
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function stripeConnectAccount() {
        $stripe = new \Stripe\StripeClient(config('stripe.connect.stripe_secret'));
        if (auth()->user()->stripe_account_id === null) {
            $stripeAccount = $stripe->accounts->create(
                [
                    'country'      => 'US',
                    'type'         => 'express',
                    'email'        => auth()->user()->email,
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers'     => ['requested' => true],
                    ],
                ]
            );

            auth()->user()->update([
                'stripe_account_id' => $stripeAccount->id,
            ]);

        }

        // return $stripe->accounts->retrieve(
        //     auth()->user()->stripe_account_id,
        //     []
        // );
        $accountOnbording = $stripe->accountLinks->create(
            [
                'account'     => auth()->user()->stripe_account_id,
                'refresh_url' => config('stripe.connect.refresh_url'),
                'return_url'  => config('stripe.connect.return_url'),
                'type'        => config('stripe.connect.type'),
            ]
        );

        // auth()->user()->update( [
        //     'stripe_connect_id' => $accountOnbording->expires_at,
        // ] );

        return redirect($accountOnbording->url);
    }

    public function stripeConnectLogin() {
        $auth = Auth::user();
        Stripe::setApiKey(config('stripe.connect.stripe_secret'));
        $loginLink = Account::createLoginLink($auth->stripe_account_id);
        return redirect($loginLink->url);
    }

    public function stripeConnectTransfer(Request $request) {
        try {
            $stripe = new \Stripe\StripeClient(config('stripe.connect.stripe_secret'));

            \Stripe\Stripe::setApiKey(config('stripe.connect.stripe_secret'));

            $transfer = \Stripe\Transfer::create([
                "amount"      => $request->amount * 100,
                "currency"    => "usd",
                "destination" => $request->stripe_account_id,
            ]);

            if ($transfer) {
                $userBalance = FundraiserBalance::find($request->balance);
                $userPayout  = Payout::find($request->payout_id);

                $userBalance->decrement('net_balance', $request->amount);
                $userBalance->increment('total_withdraw', $request->amount);

                $transaction_time = date("Y-m-d H:i:s", $transfer->created);
                $userPayout->update([
                    'status'              => "transfer",
                    'updated_by'          => Auth::id(),
                    'balance_transaction' => $transfer->balance_transaction,
                    'destination'         => $transfer->destination,
                    'transaction_time'    => $transaction_time,
                    'currency'            => $transfer->currency,
                ]);
            }

            return back()->with('success', 'Transfer Successfull');

        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }

}
