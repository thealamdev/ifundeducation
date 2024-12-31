@extends('layouts.backapp')
@section('title', 'FAQ Page')
@section('style')
<link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}">
@endsection
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
                <a href="{{ route('dashboard.pages.all-pages.index') }}" class="text-muted text-hover-primary">All Pages</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">FAQ Page</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">

        <form action="{{ route('dashboard.pages.faq-page.update', $faqPage) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column" style="display: inline-block;">
                    <span class="card-label fw-bolder fs-3 mb-1">FAQ Page</span>
                </h3>
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                    title="" data-bs-original-title="Click to Update FAQ Page" style="display: inline-block; float: right;">
                    <button type="submit" class="btn btn-sm btn-primary">Update FAQ Page</button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="m-5 p-5">
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive" style="min-width: 370px">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <!--begin::Table body-->
                            <tbody>
                                @isset($faqPage)
                                    <tr>
                                        <td colspan="3"><strong>Page</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <span class="mb-5" style="display: block;">Featured Image</span>
                                            @if ($faqPage->image)
                                                <img src="{{ asset('frontend/images/pages/'.$faqPage->image) }}" width="200" alt="{{$faqPage->image}}">
                                                <p>{{$faqPage->image}} <a href="{{ route('dashboard.pages.faq-page.image.delete', $faqPage) }}" title="Delete [{{ $faqPage->image }}]" onclick="return confirm('Are you sure you want to delete this Image? [{{ $faqPage->image }}]')" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"><i class='fas fa-trash-alt' style='color:red'></i></a></p>
                                            @endif
                                            <input type="file" id="file_input" class="form-control form-control-solid @error('image') is-invalid @enderror" name="image">
                                            @error('image')
                                                <p class="text-danger mt-2">{{ $message }}</p>
                                            @enderror</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 122px">&nbsp;&nbsp;Sub Title</td>
                                        <td style="width: 30px">&nbsp;:&nbsp;</td>
                                        <td colspan="2" style="padding: 0"><input type="text" class="form-control form-control-solid " placeholder="Enter Page Sub Title" name="sub_title" value="{{ $faqPage->sub_title }}"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top">&nbsp;&nbsp;Text Before FAQ</td>
                                        <td style="vertical-align: top">&nbsp;:&nbsp;</td>
                                        <td colspan="2" style="padding: 0">
                                            <textarea name="text_before_faq" class="form-control  form-control-solid" rows="2" placeholder="Enter Text Before FAQ">{{ $faqPage->text_before_faq }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top">&nbsp;&nbsp;Text After FAQ</td>
                                        <td style="vertical-align: top">&nbsp;:&nbsp;</td>
                                        <td colspan="2" style="padding: 0">
                                            <textarea name="text_after_faq" class="form-control  form-control-solid" rows="2" placeholder="Enter Text After FAQ">{{ $faqPage->text_after_faq }}</textarea>
                                        </td>
                                    </tr>
                                @endisset
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
            </div>
            <!--begin::Body-->
        </form>

    </div>
    <div class="card mb-5 mb-xl-8">

            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column" style="display: inline-block;">
                    <span class="card-label fw-bolder fs-3 mb-1">FAQ</span>
                </h3>
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                title="" data-bs-original-title="Click to add a FAQ">
                <a href="{{route('dashboard.pages.faq.create')}}" class="btn btn-sm btn-primary">
                    <span class="svg-icon svg-icon-3">
                        <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </span>

                    FAQ
                </a>
            </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="m-5 p-5">
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive" style="min-width: 370px">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <!--begin::Table body-->
                            <tbody>
                                @isset($faqs)
                                @foreach ($faqs as $faq)
                                <tr>
                                    <td style="white-space: nowrap; width: 118px;">
                                        ID : {{$faq->id}} <br>
                                        Status : {{$faq->status==1?'Active':'Inactive'}} <br>

                                        <a title="Edit" href="{{ route('dashboard.pages.faq.edit', $faq) }}"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotone/Communication/Write.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg width="24px" height="24px" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)">
                                                    </path>
                                                    <path
                                                        d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                        fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <form onclick="return confirm('Are you sure you want to delete this record? [ID: {{ $faq->id }}]')" title="ID: {{ $faq->id }}" class="d-inline" action="{{ route('dashboard.pages.faq.delete', $faq) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" title="Delete [ID: {{ $faq->id }}]">
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
                                    <td>
                                        <span class="mb-2" style="display: block;"><strong>Question:</strong></span>
                                        {{$faq->question}}
                                        <span class="mt-4 mb-2" style="display: block;"><strong>Answer:</strong></span>
                                        {{$faq->answer}}
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
