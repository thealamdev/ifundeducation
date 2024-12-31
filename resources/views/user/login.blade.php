@extends('layouts.frontapp')

@section('title', 'User Login')

@section('content')
    <section id="login_signup">
        <div class="container">
            <div class="row align-items-center justify-content-center">

                <div class="col-lg-5 col-xl-4 login_signup_form">
                    <div class="logo text-center">
                        <a href="">
                            <img src="{{ asset('frontend/images/logo.png') }}" alt="">
                        </a>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-4">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="floatingInput" placeholder="Email address" value="{{ old('email') }}">
                            <label for="floatingInput">Email address</label>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="floatingPassword"
                                        placeholder="Password" value="{{ old('password') }}">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <span class="input-group-text password_icon" style="cursor: pointer"><i
                                        class="fas fa-eye-slash"></i></span>
                            </div>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label " for="exampleCheck1">Remember Me</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="">Forgot Password</a>
                            @endif
                        </div>

                        <button type="submit">Login</button>

                    </form>
                    {{-- <a href="{{ route('social.google.redirect') }}" class="link_button"> <i class="fab fa-google"></i>
                        Login With
                        Google</a> --}}
                    <p class="text-center mb-2 ">Don't have an Account? <a href="{{ route('register') }}">Sign
                            Up</a></p>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        $('.password_icon').on('click', function() {

            if ($('i').hasClass('fa-eye-slash')) {

                $('i').removeClass('fa-eye-slash');

                $('i').addClass('fa-eye');

                $('#floatingPassword').attr('type', 'text');

            } else {

                $('i').removeClass('fa-eye');

                $('i').addClass('fa-eye-slash');

                $('#floatingPassword').attr('type', 'password');
            }
        });
    </script>
@endsection
