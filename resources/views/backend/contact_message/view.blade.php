@extends('layouts.backapp')
@section('title', 'Contact Message')
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
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('dashboard.contact-messages.index') }}" class="text-muted text-hover-primary">Contact
                    Message</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">
                {{ $contactMessage->your_name . ' - (' . $contactMessage->your_email . ')' }}
            </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">{{ $contactMessage->subject }}</span>
            </h3>
            <span style="padding-top: 15px;">{{ $contactMessage->created_at->toDayDateTimeString() }}</span>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <div class="row">
                <div class="col col-11 mb-2">
                    <p>{{ $contactMessage->your_name . ' - (' . $contactMessage->your_email . ')' }}</p>
                </div>
                <div class="col col-11 mb-5">
                    <span style="font-size: 16px">{!! $contactMessage->message !!}</span>
                </div>
            </div>
        </div>
        <!--begin::Body-->
    </div>



    {{-- <div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog mw-650px">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24px" height="24px" viewBox="0 0 24 24">
                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                    fill="#000000">
                                    <rect fill="#000000" x="0" y="7" width="16" height="2"
                                        rx="1"></rect>
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
                    <div class="text-center mb-13">
                        <h2 class="mb-3">Add Message</h2>
                    </div>
                    <form action="#" method="POST">
                        @csrf
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Your Name</span>
                            </label>
                            <input type="text" class="form-control form-control-solid " placeholder="Enter Your Name"
                                name="your_name" value="{{ old('your_name') }}">
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Your Email</span>
                            </label>
                            <input type="text" class="form-control form-control-solid " placeholder="Enter Your Email"
                                name="your_email" value="{{ old('your_email') }}">
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Subject</span>
                            </label>
                            <input type="text" class="form-control form-control-solid " placeholder="Enter subject"
                                name="subject" value="{{ old('subject') }}">
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Message</span>
                            </label>
                            <textarea class="form-control" rows="5" placeholder="Enter Message" name="message">{{ old('message') }}</textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('script')
    @error('name')
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: "{{ $message }}",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                padding: '1em',
                customClass: {
                    'title': 'alert_title',
                    'icon': 'alert_icon',
                    'timerProgressBar': 'bg-danger',
                }
            })
        </script>
    @enderror
@endsection
