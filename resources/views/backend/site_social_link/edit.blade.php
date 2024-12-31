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
            <li class="breadcrumb-item text-dark">Edit Social Link</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">
        <form action="{{ route('dashboard.page-options.site-social-links.update', $siteSocialLink) }}" method="POST">
            @csrf
            @method('PUT')
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column" style="display: inline-block;">
                    <span class="card-label fw-bolder fs-3 mb-1">Site Social Link (Edit)</span>
                </h3>
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                title="" data-bs-original-title="Click to Update Social Link" style="display: inline-block; float: right;">
                <button type="submit" class="btn btn-sm btn-primary">
                    Update Social Link
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
                            <option {{ $siteSocialLink->icon == 'fab fa-discord' ? 'selected' : '' }} value="fab fa-discord">fa-discord</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-facebook-f' ? 'selected' : '' }} value="fab fa-facebook-f">fa-facebook-f</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-instagram' ? 'selected' : '' }} value="fab fa-instagram">fa-instagram</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-linkedin-in' ? 'selected' : '' }} value="fab fa-linkedin-in">fa-linkedin-in</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-mastodon' ? 'selected' : '' }} value="fab fa-mastodon">fa-mastodon</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-pinterest' ? 'selected' : '' }} value="fab fa-pinterest">fa-pinterest</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-qq' ? 'selected' : '' }} value="fab fa-qq">fa-qq</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-quora' ? 'selected' : '' }} value="fab fa-quora">fa-quora</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-reddit' ? 'selected' : '' }} value="fab fa-reddit">fa-reddit</option>
                            <option {{ $siteSocialLink->icon == 'bi bi-sina-weibo' ? 'selected' : '' }} value="bi bi-sina-weibo">bi-sina-weibo</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-snapchat' ? 'selected' : '' }} value="fab fa-snapchat">fa-snapchat</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-telegram' ? 'selected' : '' }} value="fab fa-telegram">fa-telegram</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-tiktok' ? 'selected' : '' }} value="fab fa-tiktok">fa-tiktok</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-tumblr' ? 'selected' : '' }} value="fab fa-tumblr">fa-tumblr</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-twitch' ? 'selected' : '' }} value="fab fa-twitch">fa-twitch</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-twitter' ? 'selected' : '' }} value="fab fa-twitter">fa-twitter</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-wechat' ? 'selected' : '' }} value="fab fa-wechat">fa-wechat</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-whatsapp' ? 'selected' : '' }} value="fab fa-whatsapp">fa-whatsapp</option>
                            <option {{ $siteSocialLink->icon == 'fab fa-youtube' ? 'selected' : '' }} value="fab fa-youtube">fa-youtube</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Name</span>
                        </label>
                        <select name="name" class="form-control form-control-solid ">
                            <option selected value="">--Select--</option>
                            <option {{ $siteSocialLink->name == 'Discord' ? 'selected' : '' }} value="Discord">Discord</option>
                            <option {{ $siteSocialLink->name == 'Facebook' ? 'selected' : '' }} value="Facebook">Facebook</option>
                            <option {{ $siteSocialLink->name == 'Instagram' ? 'selected' : '' }} value="Instagram">Instagram</option>
                            <option {{ $siteSocialLink->name == 'LinkedIn' ? 'selected' : '' }} value="fab fa-linkedin-in">LinkedIn</option>
                            <option {{ $siteSocialLink->name == 'Mastodon' ? 'selected' : '' }} value="Mastodon">Mastodon</option>
                            <option {{ $siteSocialLink->name == 'Pinterest' ? 'selected' : '' }} value="Pinterest">Pinterest</option>
                            <option {{ $siteSocialLink->name == 'QQ' ? 'selected' : '' }} value="QQ">QQ</option>
                            <option {{ $siteSocialLink->name == 'Quora' ? 'selected' : '' }} value="Quora">Quora</option>
                            <option {{ $siteSocialLink->name == 'Reddit' ? 'selected' : '' }} value="Reddit">Reddit</option>
                            <option {{ $siteSocialLink->name == 'SinaWeibo' ? 'selected' : '' }} value="SinaWeibo">SinaWeibo</option>
                            <option {{ $siteSocialLink->name == 'SnapChat' ? 'selected' : '' }} value="SnapChat">SnapChat</option>
                            <option {{ $siteSocialLink->name == 'Telegram' ? 'selected' : '' }} value="Telegram">Telegram</option>
                            <option {{ $siteSocialLink->name == 'TikTok' ? 'selected' : '' }} value="TikTok">TikTok</option>
                            <option {{ $siteSocialLink->name == 'Tumblr' ? 'selected' : '' }} value="Tumblr">Tumblr</option>
                            <option {{ $siteSocialLink->name == 'Twitch' ? 'selected' : '' }} value="Twitch">Twitch</option>
                            <option {{ $siteSocialLink->name == 'Twitter' ? 'selected' : '' }} value="Twitter">Twitter</option>
                            <option {{ $siteSocialLink->name == 'WeChat' ? 'selected' : '' }} value="WeChat">WeChat</option>
                            <option {{ $siteSocialLink->name == 'WhatsApp' ? 'selected' : '' }} value="WhatsApp">WhatsApp</option>
                            <option {{ $siteSocialLink->name == 'YouTube' ? 'selected' : '' }} value="YouTube">YouTube</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="">Link</span>
                        </label>
                        <input type="text" class="form-control form-control-solid " placeholder="Enter Link" name="link" value="{{ $siteSocialLink->link }}">
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="">Status</span>
                        </label>
                        <select name="status" class="form-control form-control-solid ">
                            <option {{$siteSocialLink->status<>1?'selected':''}} value="0">Inactive</option>
                            <option {{$siteSocialLink->status==1?'selected':''}} value="1">Active</option>
                        </select>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Update Social Link
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
