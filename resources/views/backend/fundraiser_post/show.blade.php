@extends('layouts.backapp')
@section('title', 'Fundraiser Campaign')
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
            <li class="breadcrumb-item text-dark">{{ $fundRaiserPost->title }}</li>
        </ul>
    </div>
@endsection
@section('content')
    @if ($fundRaiserPost->status === 'reviewed')
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3>Review message</h3>
            </div>
            <div class="card-body py-3">
                @foreach ($fundRaiserPost->reviewedComments as $reviewedComment)
                    <div class="alert alert-warning">
                        Date: {{ $reviewedComment->created_at->format('d M, Y') }}
                        <br>
                        <strong> Message:</strong> {{ $reviewedComment->comments }}
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    @if ($fundRaiserPost->status === 'block')
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3>Block reason</h3>
            </div>
            <div class="card-body py-3">
                @foreach ($fundRaiserPost->blockComments as $blockComment)
                    <div class="alert alert-danger">
                        Date: {{ $blockComment->created_at->format('d M, Y') }}
                        <br>
                        <strong> Message:</strong> {{ $blockComment->comments }}
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ Str::upper($fundRaiserPost->title) }}</span>
            </h3>
            @if ($fundRaiserPost->status != 'stop' && $fundRaiserPost->status != 'completed')
                <div class="card-toolbar">
                    @if ($fundRaiserPost->status == 'pending' || $fundRaiserPost->status == 'reviewed')
                        <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends"
                            class="btn btn-sm btn-success" id="active">
                            Active
                        </a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends"
                            class="btn btn-sm btn-primary ms-2" id="reviewed">
                            Review
                        </a>
                    @elseif ($fundRaiserPost->status == 'block')
                        <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends"
                            class="btn btn-sm btn-success mx-2" id="unblock">
                            Active
                        </a>
                    @else
                        <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends"
                            class="btn btn-sm btn-info mx-2" id="block">
                            Block
                        </a>
                    @endif





                </div>
            @endif
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <tr>
                        <td width="15%"><strong>Raised</strong></td>
                        <td width="3%">:</td>
                        <td>${{ number_format($fundRaiserPost->donates->sum('net_balance'), 2) }}</td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Status</strong></td>
                        <td width="3%">:</td>
                        <td><span
                                class="badge badge-{{ $fundRaiserPost->status == 'stop' || $fundRaiserPost->status == 'block' ? 'danger' : ($fundRaiserPost->status == 'pending' ? 'warning' : 'success') }}">{{ Str::ucfirst($fundRaiserPost->status) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Category</strong></td>
                        <td width="3%">:</td>
                        <td>

                            <span class="badge badge-success">{{ $fundRaiserPost->fundraisercategory->name }}</span>

                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Goal</strong></td>
                        <td width="3%">:</td>
                        <td>${{ number_format($fundRaiserPost->goal, 2) }}</td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>End Date</strong></td>
                        <td width="3%">:</td>
                        <td>{{ $fundRaiserPost->end_date->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Shot Desctription</strong></td>
                        <td width="3%">:</td>
                        <td>{{ $fundRaiserPost->shot_description }}</td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Desctription</strong></td>
                        <td width="3%">:</td>
                        <td>{!! $fundRaiserPost->story !!}</td>
                    </tr>
                    <tr>
                        <td width="15%"><strong>Created Date</strong></td>
                        <td width="3%">:</td>
                        <td>{{ $fundRaiserPost->created_at->format('d M Y') }}</td>
                    </tr>

                </table>
            </div>
        </div>
        <!--begin::Body-->
    </div>

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Donation</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fundRaiserPost->donates as $donate)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $donate->donar_name }}</td>
                                <td>{{ $donate->donar_email }}</td>
                                <td>${{ number_format($donate->net_balance, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="alert alert-info">Donation Not Found!</div>
                                </td>
                            </tr>
                        @endforelse
                        <tr></tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Comments</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fundRaiserPost->comments as $comment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $comment->name }}</td>
                                <td>{{ $comment->email }}</td>
                                <td>{{ $comment->comment }}</td>
                                <td><span class="badge bg-primary">{{ $comment->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-info">Comments Not Found!</div>
                                </td>
                            </tr>
                        @endforelse
                        <tr></tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Campaign Updates</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>message</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fundRaiserPost->fundraiserupdatemessage as $message)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $message->message }}</td>
                                <td><span class="badge bg-primary">{{ $message->message_type }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="alert alert-info">Message Not Found!</div>
                                </td>
                            </tr>
                        @endforelse
                        <tr></tr>
                    </tbody>

                </table>
            </div>
        </div>
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
                    <form action="{{ route('dashboard.fundraiser.campaign.campaign.status') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <input type="hidden" name="status" id="status_input">
                            <input type="hidden" name="fundRaiserPost" value="{{ $fundRaiserPost->id }}">
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
            $(document).on('click', '#unblock', function() {
                status_input.val('running');
            })
            $(document).on('click', '#block', function() {
                status_input.val('block');
            })
            $(document).on('click', '#reviewed', function() {
                status_input.val('reviewed');
            })
            $(document).on('click', '#active', function() {
                status_input.val('running');
            })
        });
    </script>
@endsection
