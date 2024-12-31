@extends('layouts.backapp')
@section('title', 'Theme Options')
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
            <li class="breadcrumb-item text-dark">Theme Options</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">


    @isset($themeOption)
        <form action="{{ route('dashboard.theme-options.update', $themeOption) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column" style="display: inline-block;">
                    <span class="card-label fw-bolder fs-3 mb-1">Theme Options</span>
                </h3>
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                    title="" data-bs-original-title="Click to Update Theme Options" style="display: inline-block; float: right;">
                    <button type="submit" class="btn btn-sm btn-primary">Update Theme Options</button>
                </div>
            </div>
            <!--end::Header-->
        @else
        <form action="{{ route('dashboard.theme-options.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column" style="display: inline-block;">
                    <span class="card-label fw-bolder fs-3 mb-1">Theme Options</span>
                </h3>
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                    title="" data-bs-original-title="Click to Add Theme Options" style="display: inline-block; float: right;">
                    <button type="submit" class="btn btn-sm btn-primary">Add Theme Options</button>
                </div>
            </div>
            <!--end::Header-->
    @endisset

            <!--begin::Body-->
            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <!--begin::Table body-->
                        <tbody>
                            @isset($themeOption)
                                <tr>
                                    <td style="vertical-align: top; width: 145px;">Site Logo</td>
                                    <td style="vertical-align: top; width: 30px;">&nbsp;:&nbsp;</td>
                                    <td>
                                        @isset($themeOption->site_logo)
                                            <img src="{{ asset('frontend/images/theme_options/'.$themeOption->site_logo) }}" width="100" alt="{{ $themeOption->site_logo }}">
                                            &nbsp;&nbsp; {{ $themeOption->site_logo }}
                                        @endisset
                                        <input type="file" id="site_logo" class="form-control form-control-solid @error('site_logo') is-invalid @enderror" name="site_logo" style="padding: 5px 0 0 0;">
                                        @error('site_logo')
                                            <p class="text-danger mt-2">{{ $message }}</p>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Header</strong></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;Email</td>
                                    <td style="width:20px">&nbsp;:&nbsp;</td>
                                    <td><input type="text" class="form-control form-control-solid" placeholder="Enter Header Email" name="header_email" value="{{ $themeOption->header_email ?? old('header_email') }}"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;Phone</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><input type="text" class="form-control form-control-solid" placeholder="Enter Header Phone" name="header_phone" value="{{ $themeOption->header_phone ?? old('header_phone') }}"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Footer</strong></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top">&nbsp;&nbsp;Logo</td>
                                    <td style="vertical-align: top">&nbsp;:&nbsp;</td>
                                    <td>
                                        @isset($themeOption->footer_logo)
                                            <img src="{{ asset('frontend/images/theme_options/'.$themeOption->footer_logo) }}" width="100" alt="{{ $themeOption->footer_logo }}">
                                            &nbsp;&nbsp; {{ $themeOption->footer_logo }}
                                        @endisset
                                        <input type="file" id="footer_logo" class="form-control form-control-solid @error('footer_logo') is-invalid @enderror" name="footer_logo" style="padding: 5px 0 0 0;">
                                        @error('footer_logo')
                                            <p class="text-danger mt-2">{{ $message }}</p>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Footer - About</strong></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;Title</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><input type="text" class="form-control form-control-solid" placeholder="Enter Footer About Title" name="footer_about_title" value="{{ $themeOption->footer_about_title ?? old('footer_about_title') }}"></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top">&nbsp;&nbsp;Description</td>
                                    <td style="vertical-align: top">&nbsp;:&nbsp;</td>
                                    <td><textarea name="footer_about_description" class="form-control" rows="3" placeholder="Enter Footer About Description">{{ $themeOption->footer_about_description ?? old('footer_about_description') }}</textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Footer - Contact</strong></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;Email</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><input type="text" class="form-control form-control-solid" placeholder="Enter Footer Email" name="footer_email" value="{{ $themeOption->footer_email ?? old('footer_email') }}"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;Phone</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><input type="text" class="form-control form-control-solid" placeholder="Enter Footer Phone" name="footer_phone" value="{{ $themeOption->footer_phone ?? old('footer_phone') }}"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;Web Address</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><input type="text" class="form-control form-control-solid" placeholder="Enter Footer Web Address" name="footer_web_address" value="{{ $themeOption->footer_web_address ?? old('footer_web_address') }}"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;Web Address Link</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><input type="text" class="form-control form-control-solid" placeholder="Enter Footer Web Address Link" name="footer_web_address_link" value="{{ $themeOption->footer_web_address_link ?? old('footer_web_address_link') }}"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Copyright</strong></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;Copyright Text</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><input type="text" class="form-control form-control-solid" placeholder="Enter Copyright Text" name="copyright_text" value="{{ $themeOption->copyright_text ?? old('copyright_text') }}"></td>
                                </tr>
                            @endisset
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Table container-->
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
