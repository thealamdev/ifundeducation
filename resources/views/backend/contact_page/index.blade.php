@extends('layouts.backapp')
@section('title', 'Contact Page')
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
            <li class="breadcrumb-item text-dark">Contact Page</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">

        <form action="{{ route('dashboard.pages.contact-page.update', $contactPage) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column" style="display: inline-block;">
                    <span class="card-label fw-bolder fs-3 mb-1">Contact Page</span>
                </h3>
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                    title="" data-bs-original-title="Click to Update Contact Page" style="display: inline-block; float: right;">
                    <button type="submit" class="btn btn-sm btn-primary">Update Contact Page</button>
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
                                @isset($contactPage)
                                <tr>
                                    <td colspan="4"><strong>Page</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <span class="mb-5" style="display: block;">Featured Image</span>
                                        @if ($contactPage->image)
                                            <img src="{{ asset('frontend/images/pages/'.$contactPage->image) }}" width="200" alt="{{$contactPage->image}}">
                                            <p>{{$contactPage->image}} <a href="{{ route('dashboard.pages.contact-page.image.delete', $contactPage) }}" title="Delete [{{ $contactPage->image }}]" onclick="return confirm('Are you sure you want to delete this Image? [{{ $contactPage->image }}]')" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"><i class='fas fa-trash-alt' style='color:red'></i></a></p>
                                        @endif
                                        <input type="file" id="file_input" class="form-control form-control-solid @error('image') is-invalid @enderror" name="image">
                                        @error('image')
                                            <p class="text-danger mt-2">{{ $message }}</p>
                                        @enderror</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;Sub Title</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td colspan="2" style="padding: 0"><input type="text" class="form-control form-control-solid " placeholder="Enter Page Sub Title" name="sub_title" value="{{ $contactPage->sub_title }}"></td>
                                </tr>
                                    <tr>
                                        <td colspan="4"><strong>Address</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="width:80px">&nbsp;&nbsp;Icon</td>
                                        <td style="width:30px">&nbsp;:&nbsp;</td>
                                        <td style="width:40px"><i class="{{ $contactPage->address_icon }}" style="font-size: 18px; color: green;"></i></td>
                                        <td style="padding: 0"><input type="text" class="form-control form-control-solid " placeholder="Enter Address Icon" name="address_icon" value="{{ $contactPage->address_icon }}"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Title</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td colspan="2" style="padding: 0"><input type="text" class="form-control form-control-solid " placeholder="Enter Address Title" name="address_title" value="{{ $contactPage->address_title }}"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top">&nbsp;&nbsp;Address</td>
                                        <td style="vertical-align: top">&nbsp;:&nbsp;</td>
                                        <td colspan="2" style="padding: 0">
                                            <textarea name="address_text" class="form-control  form-control-solid" rows="2" placeholder="Enter Address">{{ $contactPage->address_text }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><strong>Email</strong></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Icon</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><i class="{{ $contactPage->email_icon }}" style="font-size: 18px; color: green;"></i></td>
                                        <td style="padding: 0"><input type="text" class="form-control form-control-solid " placeholder="Enter Email Icon" name="email_icon" value="{{ $contactPage->email_icon }}"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Title</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td colspan="2" style="padding: 0"><input type="text" class="form-control form-control-solid " placeholder="Enter Email Title" name="email_title" value="{{ $contactPage->email_title }}"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top">&nbsp;&nbsp;Address</td>
                                        <td style="vertical-align: top">&nbsp;:&nbsp;</td>
                                        <td colspan="2" style="padding: 0">
                                            <textarea name="email_text" class="form-control  form-control-solid" rows="2" placeholder="Enter Email Address">{{ $contactPage->email_text }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><strong>Phone</strong></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Icon</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td><i class="{{ $contactPage->phone_icon }}" style="font-size: 18px; color: green;"></i></td>
                                        <td style="padding: 0"><input type="text" class="form-control form-control-solid " placeholder="Enter Phone Icon" name="phone_icon" value="{{ $contactPage->phone_icon }}"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Title</td>
                                        <td>&nbsp;:&nbsp;</td>
                                        <td colspan="2" style="padding: 0"><input type="text" class="form-control form-control-solid " placeholder="Enter Phone Title" name="phone_title" value="{{ $contactPage->phone_title }}"></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top">&nbsp;&nbsp;Number</td>
                                        <td style="vertical-align: top">&nbsp;:&nbsp;</td>
                                        <td colspan="2" style="padding: 0">
                                            <textarea name="phone_text" class="form-control  form-control-solid" rows="2" placeholder="Enter Phone Number">{{ $contactPage->phone_text }}</textarea>
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
