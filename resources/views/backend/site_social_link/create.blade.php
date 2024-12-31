@extends('layouts.backapp')
@section('title', 'Site Social Link')
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
                <a href="{{ route('dashboard.page-options.site-social-links.index') }}" class="text-muted text-hover-primary">Site Social Link</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">New Social Link</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">

        <form action="{{ route('dashboard.page-options.site-social-links.store') }}" method="POST">
            @csrf
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column" style="display: inline-block;">
                    <span class="card-label fw-bolder fs-3 mb-1">Site Social Link (New)</span>
                </h3>
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                title="" data-bs-original-title="Click to add Social Link" style="display: inline-block; float: right;">
                <button type="submit" class="btn btn-sm btn-primary">
                    <span class="svg-icon svg-icon-3">
                        <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </span>
                    Social Link
                </button>
            </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">

                <div class="m-5 p-5">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Icon</span>
                        </label>
                        <select name="icon" class="form-control form-control-solid ">
                            <option selected value="">--Select--</option>
                            <option {{ old('icon') == 'fab fa-discord' ? 'selected' : '' }} value="fab fa-discord">fa-discord</option>
                            <option {{ old('icon') == 'fab fa-facebook-f' ? 'selected' : '' }} value="fab fa-facebook-f">fa-facebook-f</option>
                            <option {{ old('icon') == 'fab fa-instagram' ? 'selected' : '' }} value="fab fa-instagram">fa-instagram</option>
                            <option {{ old('icon') == 'fab fa-linkedin-in' ? 'selected' : '' }} value="fab fa-linkedin-in">fa-linkedin-in</option>
                            <option {{ old('icon') == 'fab fa-mastodon' ? 'selected' : '' }} value="fab fa-mastodon">fa-mastodon</option>
                            <option {{ old('icon') == 'fab fa-pinterest' ? 'selected' : '' }} value="fab fa-pinterest">fa-pinterest</option>
                            <option {{ old('icon') == 'fab fa-qq' ? 'selected' : '' }} value="fab fa-qq">fa-qq</option>
                            <option {{ old('icon') == 'fab fa-quora' ? 'selected' : '' }} value="fab fa-quora">fa-quora</option>
                            <option {{ old('icon') == 'fab fa-reddit' ? 'selected' : '' }} value="fab fa-reddit">fa-reddit</option>
                            <option {{ old('icon') == 'bi bi-sina-weibo' ? 'selected' : '' }} value="bi bi-sina-weibo">bi-sina-weibo</option>
                            <option {{ old('icon') == 'fab fa-snapchat' ? 'selected' : '' }} value="fab fa-snapchat">fa-snapchat</option>
                            <option {{ old('icon') == 'fab fa-telegram' ? 'selected' : '' }} value="fab fa-telegram">fa-telegram</option>
                            <option {{ old('icon') == 'fab fa-tiktok' ? 'selected' : '' }} value="fab fa-tiktok">fa-tiktok</option>
                            <option {{ old('icon') == 'fab fa-tumblr' ? 'selected' : '' }} value="fab fa-tumblr">fa-tumblr</option>
                            <option {{ old('icon') == 'fab fa-twitch' ? 'selected' : '' }} value="fab fa-twitch">fa-twitch</option>
                            <option {{ old('icon') == 'fab fa-twitter' ? 'selected' : '' }} value="fab fa-twitter">fa-twitter</option>
                            <option {{ old('icon') == 'fab fa-wechat' ? 'selected' : '' }} value="fab fa-wechat">fa-wechat</option>
                            <option {{ old('icon') == 'fab fa-whatsapp' ? 'selected' : '' }} value="fab fa-whatsapp">fa-whatsapp</option>
                            <option {{ old('icon') == 'fab fa-youtube' ? 'selected' : '' }} value="fab fa-youtube">fa-youtube</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Name</span>
                        </label>
                        {{ old('name')}}
                        <select name="name" class="form-control form-control-solid ">
                            <option selected value="">--Select--</option>
                            <option {{ old('name') == 'Discord' ? 'selected' : '' }} value="Discord">Discord</option>
                            <option {{ old('name') == 'Facebook' ? 'selected' : '' }} value="Facebook">Facebook</option>
                            <option {{ old('name') == 'Instagram' ? 'selected' : '' }} value="Instagram">Instagram</option>
                            <option {{ old('name') == 'LinkedIn' ? 'selected' : '' }} value="fab fa-linkedin-in">LinkedIn</option>
                            <option {{ old('name') == 'Mastodon' ? 'selected' : '' }} value="Mastodon">Mastodon</option>
                            <option {{ old('name') == 'Pinterest' ? 'selected' : '' }} value="Pinterest">Pinterest</option>
                            <option {{ old('name') == 'QQ' ? 'selected' : '' }} value="QQ">QQ</option>
                            <option {{ old('name') == 'Quora' ? 'selected' : '' }} value="Quora">Quora</option>
                            <option {{ old('name') == 'Reddit' ? 'selected' : '' }} value="Reddit">Reddit</option>
                            <option {{ old('name') == 'SinaWeibo' ? 'selected' : '' }} value="SinaWeibo">SinaWeibo</option>
                            <option {{ old('name') == 'SnapChat' ? 'selected' : '' }} value="SnapChat">SnapChat</option>
                            <option {{ old('name') == 'Telegram' ? 'selected' : '' }} value="Telegram">Telegram</option>
                            <option {{ old('name') == 'TikTok' ? 'selected' : '' }} value="TikTok">TikTok</option>
                            <option {{ old('name') == 'Tumblr' ? 'selected' : '' }} value="Tumblr">Tumblr</option>
                            <option {{ old('name') == 'Twitch' ? 'selected' : '' }} value="Twitch">Twitch</option>
                            <option {{ old('name') == 'Twitter' ? 'selected' : '' }} value="Twitter">Twitter</option>
                            <option {{ old('name') == 'WeChat' ? 'selected' : '' }} value="WeChat">WeChat</option>
                            <option {{ old('name') == 'WhatsApp' ? 'selected' : '' }} value="WhatsApp">WhatsApp</option>
                            <option {{ old('name') == 'YouTube' ? 'selected' : '' }} value="YouTube">YouTube</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="">Link</span>
                        </label>
                        <input type="text" class="form-control form-control-solid " placeholder="Enter Link" name="link" value="{{ old('link') }}">
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="">Status</span>
                        </label>
                        <select name="status" class="form-control form-control-solid ">
                            <option value="0">Inactive</option>
                            <option selected value="1">Active</option>
                        </select>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            <span class="svg-icon svg-icon-3">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </span>
                            Social Link
                        </span>
                    </button>
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
