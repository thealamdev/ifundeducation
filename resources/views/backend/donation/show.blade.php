@extends('layouts.backapp')
@section('title', 'Donation')
@section('breadcrumb')
    <div data-kt-place="true" data-kt-place-mode="prepend"
        data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
        class="page-title d-flex align-items-center me-3">
        <!--begin::Title-->
        <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Donation</h1>
        <!--end::Title-->
        <!--begin::Separator-->
        <span class="h-20px border-gray-200 border-start mx-4"></span>
        <!--end::Separator-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Donation</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Donation</span>
            </h3>

        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <tbody>
                        <tr>
                            <td width="200"><strong>Id</strong></td>
                            <td width="3">:</td>
                            <td>{{ $donation->id }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Campaign</strong></td>
                            <td width="3">:</td>
                            <td><a href="{{ route('front.fundraiser.post.show', $donation->fundraiser->slug) }}"
                                    target="_blank">{{ $donation->fundraiser->title }}</a></td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Date</strong></td>
                            <td width="3">:</td>
                            <td>{{ $donation->created_at->isoFormat('MMM D, YYYY') }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Amount</strong></td>
                            <td width="3">:</td>
                            <td>${{ number_format($donation->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Stripe Fee</strong></td>
                            <td width="3">:</td>
                            <td>${{ number_format($donation->stripe_fee, 2) }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Platform Fee</strong></td>
                            <td width="3">:</td>
                            <td>${{ number_format($donation->platform_fee, 2) }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Net Blance</strong></td>
                            <td width="3">:</td>
                            <td>${{ number_format($donation->net_balance, 2) }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Currency</strong></td>
                            <td width="3">:</td>
                            <td>{{ $donation->currency }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Status</strong></td>
                            <td width="3">:</td>
                            <td>{{ $donation->status }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Stripe Charge Id</strong></td>
                            <td width="3">:</td>
                            <td>{{ $donation->charge_id }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Stripe transaction Id</strong></td>
                            <td width="3">:</td>
                            <td>{{ $donation->balance_transaction_id }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Donor Name</strong></td>
                            <td width="3">:</td>
                            <td>{{ $donation->donar_name ?? 'Guest' }}</td>
                        </tr>
                        <tr>
                            <td width="200"><strong>Donor Email</strong></td>
                            <td width="3">:</td>
                            <td>{{ $donation->donar_email ?? '--' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
