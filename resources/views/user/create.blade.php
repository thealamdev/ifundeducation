@extends('layouts.frontapp')

@section('title', 'User Register')

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
                    <form action="" method="POST">
                        @csrf
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name') }}"
                                required>
                            <label for="first_name">First Name</label>
                            @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                name="last_name" id="last_name" placeholder="Last Name" value="{{ old('last_name') }}"
                                required>
                            <label for="last_name">Last Name</label>
                            @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                id="email" placeholder="Email address" value="{{ old('email') }}" required>
                            <label for="email">Email address</label>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="form-floating  mb-4">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Password" value="{{ old('password') }}"
                                required>
                            <label for="password">Password</label>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> --}}
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

                        <button type="submit">Sign Up</button>

                    </form>
                    <p class="text-center mb-2 ">Already have an Account? <a href="{{ route('login') }}">Login</a></p>
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
