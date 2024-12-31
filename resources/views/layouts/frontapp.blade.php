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
    {{-- <meta property="og:site_name" content="Laravel Secrets">
    <meta property="og:title" content="{{ $fundRaiserPost->title }}">
    <meta property="og:description" content="">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en">
    <meta property="og:url" content="https://laravelsecrets.com/">
    <meta property="og:image" content="{{ asset('storage/fundraiser_post/' . $fundRaiserPost->image) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"
        content="Build your knowledge with the hidden Laravel Secrets you find in this book. Learn about the why and not the what.">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@stefanbauerme">
    <meta name="twitter:creator" content="@stefanbauerme">
    <meta name="twitter:title" content="{{ $fundRaiserPost->title }}">
    <meta name="twitter:image" content="{{ asset('storage/fundraiser_post/' . $fundRaiserPost->image) }}"> --}}

    <title>@yield('title') - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    @yield('style')
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}">
    <link type="text/css" href="{{ asset('frontend/css/sweetalert2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">

</head>

<body>

    <!-- header part start  -->
    {{-- <header id="top_header">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-6">
                    <div class="header_left">
                        <p><i class="fa-sharp fa-solid fa-paper-plane"></i> {{ @$themeOption->header_email }}</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="header_right">
                        <ul>
                            @guest()
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Sign Up</a></li>
                            @else
                                <li>
                                    <a href="#">
                                        @if (auth()->user()->photo)
                                            <img src="{{ asset('storage/profile_photo/' . auth()->user()->photo) }}"
                                                alt="{{ auth()->user()->first_name }}" width="35"
                                                class="rounded-circle">
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
                                        <li>
                                            <a>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.dashboard.index') }}">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.profile.edit') }}">Profile</a>
                                        </li>
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
            </div>
        </div>
    </header> --}}
    <!-- header part end -->

    <!-- main menu part start -->
    <nav class="navbar navbar-expand-md sticky-top">
        <div class="container">
            <a class="logo" href="{{ route('front.index') }}">
                <img src=" {{ asset('frontend/images/theme_options/' . @$themeOption->site_logo) }}" class="img-fluid"
                    alt="{{ config('app.name') }}">
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
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('front.page', 'about-us') ? 'active' : '' }}"
                            href="{{ route('front.page', 'about-us') }}">about</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('front.contact') ? 'active' : '' }}"
                            href="{{ route('front.contact') }}">contact</a>
                    </li> --}}
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
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">start a fundraiser</a>
                    </li> --}}
                </ul>

            </div>
        </div>
    </nav>
    <!-- main menu part end -->

    @yield('content')

    <!-- footer part start -->
    <footer id="footer" class="wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="footer_about">
                        <img src="{{ asset('frontend/images/theme_options/' . @$themeOption->footer_logo) }}"
                            alt="{{ config('app.name') }}" class="img-fluid">
                        <strong>{{ @$themeOption->footer_about_title }}</strong>
                        <p>{{ @$themeOption->footer_about_description }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="footer_contact px-lg-3">
                        <h3>Links</h3>
                        <div class="d-flex">
                            <ul class="w-50">
                                @isset($footerMenu)
                                    @foreach ($footerMenu as $menuItem)
                                        <li><a href="{{ $menuItem->link }}"><i
                                                    class="far fa-arrow-alt-circle-right"></i>{{ $menuItem->name }}</a>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer_contact">
                        <h3>Contact</h3>
                        <ul>
                            <li><i class="fas fa-envelope"></i> {{ @$themeOption->footer_email }}</li>
                            {{-- <li><i class="fas fa-globe"></i> <a style="display: inline-block;"
                                    href="{{ @$themeOption->footer_web_address_link }}">{{ @$themeOption->footer_web_address }}</a>
                            </li>
                            <li><i class="fas fa-phone"></i> {{ @$themeOption->footer_phone }}</li> --}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row bottom_footer align-items-center">
                <div class="col-md-6">
                    <div class="footer_copy">
                        <p>{{ @$themeOption->copyright_text }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="footer_social">
                        @isset($siteSocialLink)
                            @foreach ($siteSocialLink as $linkItem)
                                <li><a href="{{ $linkItem->link }}"><i class="{{ $linkItem->icon }}"></i></a></li>
                            @endforeach
                        @endisset
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer part end -->


    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    <script src="{{ asset('frontend/js/sweetalert2.min.js') }}"></script>

    @include('flashmessage')
    @yield('script')
</body>

</html>
