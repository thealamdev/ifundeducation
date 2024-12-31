<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\PayoutEmailVerification;
use App\Models\ThemeOption;
use App\Models\User;
use App\Notifications\PayoutEmailVerification as PayoutNotify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class PayoutController extends Controller {

    public function verifyPayoutEmail(Request $request) {
        $user   = User::find($request->user_id);
        $code   = random_int(100000, 999999);
        $verify = PayoutEmailVerification::create([
            'user_id'      => $request->user_id,
            'code'         => $code,
            'expairy_date' => Carbon::now()->addMinutes(2),
        ]);

        try {
            $user->notify(new PayoutNotify($verify));
        } catch (\Exception) {
            return back()->with('error', 'Not sending an email  please try again');
        }
        return redirect()->route('withdrawals.verify.code.form');
    }

    public function verifyCodeForm() {
        $verifyCode = PayoutEmailVerification::where('user_id', Auth::id())->whereDate('created_at', '=', Carbon::today()->toDateString())->where('apply', NULL)->orderBy('id', 'desc')->first();
        if (!$verifyCode) {
            return redirect()->route('user.dashboard.index');
        }
        $nowTime     = time();
        $expaireTime = strtotime($verifyCode->expairy_date);
        if ($expaireTime < $nowTime) {
            return redirect()->route('withdrawals.index')->with('info', 'Time Expire!');
        }
        return view('withdrawals.verify');
    }

    public function verifyCodeSubmit(Request $request) {
        $request->validate([
            'code' => 'required',
        ]);
        $verifyCode = PayoutEmailVerification::where('code', $request->code)->first();
        if ($verifyCode) {
            $nowTime     = time();
            $expaireTime = strtotime($verifyCode->expairy_date);
            if ($expaireTime < $nowTime) {
                return back()->with('warning', 'Time Expire. Please, try again later');
            } elseif ($verifyCode->apply != null) {
                return back()->with('warning', 'Already Use This Code!');
            } else {
                $verifyCode->update([
                    'apply' => 'yes',
                ]);
                $request->session()->put('paymentVerifySuccess_' . auth()->user()->id, 'Verify success!');
                return redirect()->route('withdrawals.payout.view')->with('success', 'Verification Successfull!');
            }

        } else {
            return back()->with('warning', 'Invalid Code!');
        }
    }

    public function payoutView(Request $request) {
        $verifyCode = PayoutEmailVerification::where('user_id', Auth::id())->where('apply', 'yes')->whereDate('created_at', '=', Carbon::today()->toDateString())->orderBy('id', 'desc')->first();

        if ($verifyCode) {
            $endTime     = time();
            $expaireTime = strtotime($verifyCode->expairy_date) + 300;
            if ($expaireTime < $endTime) {
                $request->session()->forget('paymentVerifySuccess_' . auth()->user()->id);
                return redirect()->route('withdrawals.index')->with('info', 'Payout Time Expaire. Please, try again later');
            }
        }
        $verifySession = $request->session()->get('paymentVerifySuccess_' . auth()->user()->id);
        if (!$verifySession || !$verifyCode) {
            return redirect()->route('withdrawals.index')->with('info', 'Payout verification process incomplete!');
        }

        $balance = Auth::user()->load('balance');
        return view('withdrawals.payout', compact('balance'));
    }
    public function payoutRequest(Request $request) {

        $request->validate([
            'amount' => 'required',
        ]);

        $verifyCode = PayoutEmailVerification::where('user_id', Auth::id())->where('apply', 'yes')->whereDate('created_at', '=', Carbon::today()->toDateString())->orderBy('id', 'desc')->first();

        if ($verifyCode) {
            $endTime     = time();
            $expaireTime = strtotime($verifyCode->expairy_date) + 300;
            if ($expaireTime < $endTime) {
                $request->session()->forget('paymentVerifySuccess_' . auth()->user()->id);
                return redirect()->route('withdrawals.index')->with('info', 'Payout Time Expaire. Please, try again later');
            }
        }

        if (!$verifyCode) {
            return redirect()->route('withdrawals.index')->with('info', 'Payout verification process incomplete!');
        }

        $balance = Auth::user()->load('balance');

        if ((int) $balance->balance->net_balance < $request->amount) {
            return back()->with('warning', 'Your balance is insufficient to process the payout request.');
        }
        $payout = Payout::create([
            'user_id' => Auth::id(),
            'amount'  => $request->amount,
            'status'  => 'processing',
        ]);

        $request->session()->forget('paymentVerifySuccess_' . auth()->user()->id);

        return redirect()->route('withdrawals.index')->with('success', 'Payout Request Successfully Send!');
    }

    public function downloadPayoutList(Request $request) {
        // return $request;

        $themeOption = ThemeOption::first();

        $payoutRequestall = Payout::where('user_id', Auth::id());

        if ($request->all()) {
            $payoutRequestall->where(function ($query) use ($request) {
                if ($request->pdf_status) {
                    $query->where('pdf_status', '=', $request->status);
                }
                if ($request->pdf_fromdate) {
                    $from_date = date("Y-m-d", strtotime($request->pdf_fromdate));
                    $query->where('created_at', '>=', $from_date);
                }
                if ($request->pdf_todate) {
                    $to_date = date("Y-m-d", strtotime($request->pdf_todate));
                    $query->where('created_at', '<=', $to_date);
                }
            });
        }

        $payoutRequestall = $payoutRequestall->get();
        // return $campaigns;
        if ($payoutRequestall->isEmpty()) {
            return back()->with('warning', 'Payout history not found!');
        }

        $table_columns = [];
        if ($request->payout_id_column) {
            array_push($table_columns, 'payout_id_column');
        }
        if ($request->amount_column) {
            array_push($table_columns, 'amount_column');
        }
        if ($request->date_column) {
            array_push($table_columns, 'date_column');
        }
        if ($request->status_column) {
            array_push($table_columns, 'status_column');
        }

        // return $table_columns;

        $data = [
            'payoutRequestall' => $payoutRequestall,
            'themeOption'      => $themeOption,
            'table_column'     => $table_columns,
        ];
        $pdf = PDF::loadView('pdf.frontend.payoutpdf', $data);
        $pdf->download('payout.pdf');
        return back();
    }

    // admin or super admin parts
    public function payoutListAdmin() {
        return view('backend.payout.index');
    }
    public function payoutListAdminDataTable(Request $request) {
        $payouts = Payout::with('user:id,first_name,last_name,email')->orderBy('id', 'desc');
        // if ($request->all()) {
        //     $posts->where(function ($query) use ($request) {
        //         if ($request->title) {
        //             $query->where('id', '=', $request->title);
        //         }
        //         if ($request->fromdate) {
        //             $from_date = date("Y-m-d", strtotime($request->fromdate));
        //             $query->where('created_at', '>=', $from_date);
        //         }
        //         if ($request->todate) {
        //             $to_date = date("Y-m-d", strtotime($request->todate));
        //             $query->where('end_date', '<=', $to_date);
        //         }
        //     });
        // }
        return DataTables::of($payouts)

            ->addColumn('email', function ($payouts) {
                return $payouts->user->email;

            })
            ->editColumn('amount', function ($payouts) {
                return '$' . number_format($payouts->amount, 2);
            })
            ->editColumn('status', function ($payouts) {
                $sts    = $payouts->status == 'transfer' ? 'success' : 'warning';
                $status = '<span class="badge badge-' . $sts . '">' . Str::ucfirst($payouts->status) . '</span>';
                return $status;
            })
            ->editColumn('admin_view', function ($payouts) {
                return $payouts->admin_view == 0 ? 'unread' : 'read';
            })
            ->editColumn('created_at', function ($payouts) {
                return $payouts->created_at->format('M d, Y');
            })
            ->addColumn('action_column', function ($payouts) {
                $links = '';

                $links .= '<div class="text-end"><a href="' . route('dashboard.fundraiser.payout.details', $payouts->id) . '" class="btn btn-sm btn-primary" title="View"> View</a></div>';

                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function payoutdetailsAdmin($id) {
        $payout = Payout::with('user.balance')->find($id);
        $payout->update([
            'admin_view' => 1,
        ]);
        return view('backend.payout.details', compact('payout'));
    }
}
