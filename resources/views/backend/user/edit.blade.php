@extends('layouts.backapp')
@section('title', 'Edit Profile')
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
            <li class="breadcrumb-item text-dark">Edit Profile</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">

        <form action="{{ route('dashboard.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column" style="display: inline-block;">
                    <span class="card-label fw-bolder fs-3 mb-1">Edit Profile</span>
                </h3>
            </div>
            <div class="card-body py-3">

                <div class="m-5 p-5 col-lg-8">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="">First Name</span>
                        </label>
                        <input type="text" class="form-control form-control-solid " placeholder="First Name"
                            name="first_name" value="{{ old('first_name', @$user->first_name) }}">
                        @error('first_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="">Last Name</span>
                        </label>
                        <input type="text" class="form-control form-control-solid " placeholder="Last Name"
                            name="last_name" value="{{ old('last_name', @$user->last_name) }}">
                        @error('last_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="">Email</span>
                        </label>
                        <input type="text" class="form-control form-control-solid " placeholder="Email" name="email"
                            value="{{ old('email', @$user->email) }}">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="">Password</span>
                        </label>
                        <input type="password" class="form-control form-control-solid " placeholder="Password"
                            name="password" value="{{ old('password') }}">
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="">Confirm Password</span>
                        </label>
                        <input type="password" class="form-control form-control-solid " placeholder="Confirm Password"
                            name="password_confirmation" value="{{ old('password_confirmation') }}">
                        @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label for="file_input" class="d-flex align-items-center fs-6 fw-bold mb-2">Profile Photo:</label>
                        <input class="form-control form-control-solid @error('photo') is-invalid @enderror" id="file_input"
                            type="file" name="photo">
                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px;">Image
                            ratio 150x150px and
                            maximum image size 300kb.
                        </p>
                        @error('photo')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <div class="mt-2">
                            <img src="{{ asset('storage/profile_photo/' . auth()->user()->photo) }}" id="show_img"
                                alt="" width="100">
                        </div>
                    </div>
                </div>

                <div class="text-center col-lg-8">
                    <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            <span class="svg-icon svg-icon-3">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </span>
                            Update
                        </span>
                    </button>
                </div>
            </div>
            <!--begin::Body-->
        </form>
    </div>

@endsection

@section('script')
    <script>
        //image change

        let imgf = document.getElementById("file_input");
        let output = document.getElementById("show_img");

        imgf.addEventListener("change", function(event) {
            let tmppath = URL.createObjectURL(event.target.files[0]);
            output.src = tmppath;
        });
    </script>
@endsection
