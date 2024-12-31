@extends('layouts.backapp')
@section('title', 'Update Message')
@section('breadcrumb')
    <div data-kt-place="true" data-kt-place-mode="prepend"
        data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
        class="page-title d-flex align-items-center me-3">
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Message</li>
        </ul>
    </div>
@endsection


@section('content')
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Message
            </h3>
            <div>
                <a href="{{ route('dashboard.campaign.message.admin.message.status.update', $message->id) }}"
                    class="btn btn-sm text-white {{ $message->status == 1 ? 'bg-danger' : 'bg-success' }}">{{ $message->status == 1 ? 'Block' : 'Active' }}</a>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="data-table">
                    <tbody>
                        <tr>
                            <td width="10%"><strong>Message</strong></td>
                            <td width="5">:</td>
                            <td>{{ $message->message }}</td>
                        </tr>
                        <tr>
                            <td width="10%"><strong>Campaign</strong></td>
                            <td width="5">:</td>
                            <td>{{ $message->fundraiserpost->title }}</td>
                        </tr>
                        <tr>
                            <td width="10%"><strong>Created</strong></td>
                            <td width="5">:</td>
                            <td>{{ $message->created_at->format('D m, Y') }}</td>
                        </tr>
                        <tr>
                            <td width="10%"><strong>Status</strong></td>
                            <td width="5">:</td>
                            <td>{{ $message->status == 1 ? 'Active' : 'blocked' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
