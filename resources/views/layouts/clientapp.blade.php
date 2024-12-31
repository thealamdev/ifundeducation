@php
    use App\Models\ThemeOption;
    use App\Models\FooterMenu;
    use App\Models\SiteSocialLink;
    $themeOption = ThemeOption::first();
    $footerMenu = FooterMenu::where('status', 1)->get();
    $siteSocialLink = SiteSocialLink::where('status', 1)->get();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @yield('style')
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.2.0.2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}">
    <link type="text/css" href="{{ asset('frontend/css/sweetalert2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">

</head>

<body id="client_admin">


    <!-- main menu part start -->
    <nav class="navbar navbar-expand-md sticky-top">
        <div class="container-fluid">
            <div class="mobile_menu_icon d-md-none">
                <i class="fa-solid fa-list"></i>
            </div>
            <a class="logo" href="{{ route('front.index') }}">
                <img src=" {{ asset('frontend/images/theme_options/' . @$themeOption->site_logo) }}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#iNav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="iNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('front.index') ? 'active' : '' }}"
                            href="{{ route('front.index') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('front.fundraiser') ? 'active' : '' }}"
                            href="{{ route('front.fundraiser') }}">Fundraiser</a>
                    </li>
                    @guest()
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Sign In</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Sign Up</a></li>
                    @else
                        <li class="login_last_item">
                            <a href="#">
                                @if (auth()->user()->photo)
                                    <img src="{{ asset('storage/profile_photo/' . auth()->user()->photo) }}"
                                        alt="{{ auth()->user()->first_name }}" width="35" class="rounded-circle">
                                @elseif(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" class="rounded-circle"
                                        alt="{{ auth()->user()->first_name }}" width="35">
                                @else
                                    <img src="{{ Avatar::create(auth()->user()->first_name)->setDimension(35)->setFontSize(14)->toBase64() }}"
                                        alt="{{ auth()->user()->first_name }}">
                                @endif
                                <i class="fa-solid fa-angle-down"></i>
                            </a>
                            <ul>
                                @foreach (auth()->user()->roles as $role)
                                    <li><span class="badge bg-success w-100">{{ Str::upper($role->name) }}</span></li>
                                @endforeach
                                <li>
                                    <a>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</a>
                                </li>
                                @role('super-admin|admin')
                                    <li>
                                        <a href="{{ route('dashboard.index') }}" target="_blank">Dashboard</a>
                                    </li>
                                @endrole
                                @role('donor|fundraiser')
                                    <li>
                                        <a href="{{ route('user.dashboard.index') }}">Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.profile.edit') }}">Profile</a>
                                    </li>
                                @endrole

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">Sign
                                            Out</a>

                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest

                </ul>

            </div>
        </div>
    </nav>
    <!-- main menu part end -->
    <section class="account_section">
        <div class="container-fluid ps-0">
            <div class="d-flex flex-row">
                @include('frontend.dashboard.sidebar')

                <div class="w-100">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    <!-- footer part start -->
    <footer class="wow fadeInUp py-3 bg-white" style="visibility: visible; animation-name: fadeInUp;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class=" text-center">
                        <p>{{ @$themeOption->copyright_text }}</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer part end -->


    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    <script src="{{ asset('frontend/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables-2.0.2.min.js') }}"></script>
    @include('flashmessage')
    @yield('script')
</body>

</html>
