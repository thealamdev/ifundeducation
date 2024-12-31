@extends('layouts.clientapp')
@section('title', 'Edit Profile')

@section('content')
    <div class="mb-4 row">
        <div class="col-md-6">
            <div class="account_content_area pr-0">
                <h3>Password</h3>
                <form method="post" action="{{ route('password.update') }}" class="account_content_area_form">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="oldPasss" class="form-label">Old Password</label>
                            <input type="password" value="{{ old('current_password') }}" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror" id="oldPasss">
                            @if ($errors->updatePassword->get('current_password'))
                                @foreach ((array) $errors->updatePassword->get('current_password') as $message)
                                    <p class="text-danger">{{ $message }}
                                    </p>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-12 mb-3">
                            <label for="newPasss" class="form-label">New Password</label>
                            <input type="password" name="password" value="{{ old('password') }}"
                                class="form-control @error('password') is-invalid @enderror" id="newPasss">
                            @if ($errors->updatePassword->get('password'))
                                @foreach ((array) $errors->updatePassword->get('password') as $message)
                                    <p class="text-danger">{{ $message }}
                                    </p>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-12 mb-3">
                            <label for="cPasss" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                class="form-control @error('password_confirmation') is-invalid @enderror" id="cPasss">
                            @if ($errors->updatePassword->get('password_confirmation'))
                                @foreach ((array) $errors->updatePassword->get('password_confirmation') as $message)
                                    <p class="text-danger">{{ $message }}
                                    </p>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-12">
                            <button type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 ps-0">
            <div class="account_content_area">
                <h3>Email</h3>
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('account.setting.update') }}" class="account_content_area_form">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="oldPasss" class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" id="oldPasss">
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div>
                                    <p class="mt-2">
                                        {{ __('Your email address is unverified.') }}

                                        <button form="send-verification" class="btn btn-warning">
                                            {{ __('re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 text-success">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="col-12">
                            <button type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
