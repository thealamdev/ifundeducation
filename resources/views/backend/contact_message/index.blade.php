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
            <li class="breadcrumb-item text-dark">Contact Message</li>
        </ul>
    </div>
@endsection

@section('style')
<style>
    .page-item:first-child .page-link {
        font-size: 22px;
        border-top-left-radius: 0.475rem;
        border-bottom-left-radius: 0.475rem;
    }
</style>
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">All Messages <span style="font-weight: 400; font-size: 12px">{{$totalUnreadMessages>0?'('.$totalUnreadMessages.' unread messages.)':''}}</span></span>
            </h3>
            <div class="card-toolbar">
                <form action="{{ route('dashboard.contact-messages.search') }}" method="GET">
                    <input type="text" class="form-control form-control-solid " placeholder="Search" title="Search" name="search"
                    value="{{ old('search') }}" style="display: inline-block; width: 255px;"><button type="submit"
                    class="btn btn-sm btn-light-primary" style="height: 40px;" title="Search">
                        <i class="fa fa-search" aria-hidden="true" style="font-size: 18px; padding: 0;"></i>
                    </button>
                </form>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <div class="row">
                <div class="col col-md-12 pb-2" style="font-size: 14px; border-bottom: 1px solid #e3e3e3;">
                    {{$contactMessages->links()}}
                </div>
            </div>
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bolder text-muted">
                            <th>ID</th>
                            <th>Sender's Name & Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Received</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @isset($contactMessages)
                        @foreach ($contactMessages as $contactMessage)
                            <tr style="font-weight: {{$contactMessage->status=='read'?'400':'700'}}">
                                <td>
                                    {{ $contactMessage->id }}
                                </td>
                                <td>
                                    {!! $contactMessage->your_name.nl2br(e('
                                    ')).$contactMessage->your_email !!}
                                </td>
                                <td>
                                    {{ $contactMessage->subject }}
                                </td>
                                <td>
                                    {{ $contactMessage->status }}
                                </td>
                                <td>
                                    {{$contactMessage->created_at->toDayDateTimeString()}}
                                </td>
                                <td class="text-end">
                                    <a title="View" href="{{ route('dashboard.contact-messages.show', $contactMessage) }}"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="far fa-eye"></i>
                                    </a>

                                    <form onclick="return confirm('Are you sure you want to delete this record? [ID: {{ $contactMessage->id }}]')" class="d-inline" action="{{ route('dashboard.contact-messages.permanent.destroy', $contactMessage) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" title="Delete [ID: {{ $contactMessage->id }}]">
                                            <!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg width="24px" height="24px" viewBox="0 0 24 24">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24">
                                                        </rect>
                                                        <path
                                                            d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                                            fill="#000000" fill-rule="nonzero"></path>
                                                        <path
                                                            d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                            fill="#000000" opacity="0.3"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @endisset
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
            <div class="row">
                <div class="col col-md-12 pt-2" style="font-size: 14px; border-top: 1px solid #e3e3e3;">
                    {{$contactMessages->links()}}
                </div>
            </div>
        </div>
        <!--begin::Body-->
    </div>

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
