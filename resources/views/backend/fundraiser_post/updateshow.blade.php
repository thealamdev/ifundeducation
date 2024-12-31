@extends('layouts.backapp')
@section('title', 'All Fundraiser Category')
@section('breadcrumb')
    <div data-kt-place="true" data-kt-place-mode="prepend"
        data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
        class="page-title d-flex align-items-center me-3">
        <!--begin::Title-->
        <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Fundraiser Campaign</h1>
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
            <li class="breadcrumb-item text-dark">{{ $currentPost->title }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Update Request</span>
            </h3>
            <div class="card-toolbar">
                @if ($updatePost->status == 'pending')
                    <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends"
                        class="btn btn-sm btn-info me-1" id="accept">
                        Accept
                    </a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends"
                        class="btn btn-sm btn-warning" id="cancel">
                        Cancel
                    </a>
                @endif

            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <tr>
                        <td width="15%">
                            <strong>Fundraiser</strong>
                        </td>
                        <td width="3%">:</td>
                        <td>
                            {{ $currentPost->title }}
                            <br>
                            <p class="bg-info badge mb-0">to <i class="fas fa-long-arrow-alt-down"></i></p>
                            <p>{{ $updatePost->title }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Category</strong></td>
                        <td width="3%">:</td>
                        <td>
                            <span class="badge badge-success">{{ $currentPost->fundraisercategory->name }}</span>
                            <p class="bg-info badge my-1">to <i class="fas fa-long-arrow-alt-right"></i></p>
                            <span class="badge badge-success">{{ $updatePost->fundraisercategory->name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Status</strong></td>
                        <td width="3%">:</td>
                        <td><span class="badge badge-warning">{{ Str::ucfirst($updatePost->status) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Goal</strong></td>
                        <td width="3%">:</td>
                        <td>
                            ${{ number_format($currentPost->goal, 2) }}
                            <p class="bg-info badge my-1">to <i class="fas fa-long-arrow-alt-right"></i></p>
                            ${{ number_format($updatePost->goal, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>End Date</strong></td>
                        <td width="3%">:</td>
                        <td>
                            {{ $currentPost->end_date->format('d M Y') }}
                            <p class="bg-info badge my-1">to <i class="fas fa-long-arrow-alt-right"></i></p>
                            {{ $updatePost->end_date->format('d M Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Shot Desctription</strong></td>
                        <td width="3%">:</td>
                        <td>
                            {{ $currentPost->shot_description }}
                            <br>
                            <p class="bg-info badge my-1">to <i class="fas fa-long-arrow-alt-down"></i></p>
                            <br>
                            {{ $updatePost->shot_description }}
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Desctription</strong></td>
                        <td width="3%">:</td>
                        <td>
                            {!! $currentPost->story !!}

                            <p class="bg-info badge m-0">to <i class="fas fa-long-arrow-alt-down"></i></p>
                            <br>
                            {!! $updatePost->story !!}
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Created Date</strong></td>
                        <td width="3%">:</td>
                        <td>
                            {{ $currentPost->created_at->format('d M Y') }}
                            <p class="bg-info badge m-0">to <i class="fas fa-long-arrow-alt-right"></i></p>
                            {{ $updatePost->created_at->format('d M Y') }}
                        </td>
                    </tr>

                </table>
            </div>
        </div>
        <!--begin::Body-->
    </div>

    <div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog mw-650px">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24px" height="24px" viewBox="0 0 24 24">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                    fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1">
                                    </rect>
                                    <rect fill="#000000" opacity="0.5"
                                        transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                        x="0" y="7" width="16" height="2" rx="1">
                                    </rect>
                                </g>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <div class=" mb-13">
                        <h2 class="mb-3">Comments</h2>
                    </div>
                    <form action="{{ route('dashboard.fundraiser.campaign.request.campaign.update') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <input type="hidden" name="status" id="status_input">
                            <input type="hidden" name="update_post_id" value="{{ $updatePost->id }}">
                            <textarea name="comment" class="form-control form-control-solid @error('name') is-invalid @enderror" rows="8">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="">
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(function($) {
            let status_input = $('#status_input');
            $(document).on('click', '#accept', function() {
                status_input.val('updated');
            })
            $(document).on('click', '#cancel', function() {
                status_input.val('cancelled');
            })
        });
    </script>
@endsection
