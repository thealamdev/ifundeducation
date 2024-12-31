@extends('layouts.frontapp')
@section('title', 'Home')
@section('content')
    <!-- hero part  -->
    <section id="banner">
        <div class="banner_item"
            style="background:url({{ asset('frontend/images/home_page_banner/' . @$homePageBanner->image) }})">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="banner_caption">
                        {!! @$homePageBanner->title !!}
                        <p>{{ @$homePageBanner->description }}</p>
                        <a href="{{ @$homePageBanner->button_link }}">{{ @$homePageBanner->button_text }}</a>
                        <div class="search_box mt-5">

                            <form action="{{ route('front.fundraiser.search') }}" method="GET">
                                <div class="input-group ">
                                    <input type="text" class="form-control" value="{{ Request::get('q') }}"
                                        name="q" placeholder="Find fundraisers...">
                                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i>
                                        Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hero part end -->
    <!-- simple block part start  -->
    <section id="simple_block">
        <div class="container">
            <div class="row">
                @isset($home3ColumnBlocks)
                    @foreach ($home3ColumnBlocks as $home3ColumnBlock)
                        <div class="col-lg-4">
                            <a href="{{ $home3ColumnBlock->link }}">
                                <div class="block_inner">
                                    <i class="{{ $home3ColumnBlock->icon }}"></i>
                                    <h3>{{ $home3ColumnBlock->title }}</h3>
                                    <p>{{ $home3ColumnBlock->short_description }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </section>
    <!-- simple block part end  -->

    <!-- Fundraisers area start -->
    <section id="fundraisers">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_header">
                        <h2>Fundraisers</h2>
                        <a href="{{ route('front.fundraiser') }}">View All <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($fundRaiserPosts as $fundRaiserPost)
                    <div class="col-lg-4 col-md-6">
                        <div class="fundraisers_card fundraisers_card_card">
                            <div class="save_btn">
                                <form action="{{ route('wishlist.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $fundRaiserPost->id }}" name="post_id">
                                    <a href="{{ route('wishlist.store') }}"
                                        onclick="event.preventDefault();
                                    this.closest('form').submit();"
                                        class="{{ in_array($fundRaiserPost->id, $wishlists_id) == true ? 'active' : '' }}"><i
                                            class="fas fa-heart"></i></a>
                                </form>

                            </div>
                            @if ($fundRaiserPost->image)
                                <img src="{{ asset('storage/fundraiser_post/' . $fundRaiserPost->image) }}"
                                    alt="{{ $fundRaiserPost->title }}">
                            @else
                                <img src="{{ Avatar::create($fundRaiserPost->title)->setBackground('#ddd')->setDimension(250)->setFontSize(16)->toBase64() }}"
                                    alt="{{ $fundRaiserPost->title }}">
                            @endif
                            <h3><a
                                    href="{{ route('front.fundraiser.post.show', $fundRaiserPost->slug) }}">{{ $fundRaiserPost->title }}</a>
                            </h3>
                            <ul class="fundraisers_card_sub">
                                <li> <i
                                        class="fas fa-university"></i>{{ $fundRaiserPost->user->academic_profile->university->name }}
                                </li>
                            </ul>
                            <ul class="fundraisers_card_sub">
                                <li><i class="fas fa-tag text-dark"></i>{{ @$fundRaiserPost->fundraisercategory->name }}
                                </li>
                            </ul>
                            <p>{{ $fundRaiserPost->shot_description }}</p>
                            <div class="progress mt-3" style="height: 13px;">
                                <div class="progress-bar progress-bar-striped" role="progressbar"
                                    aria-label="Example with label"
                                    style="width: {{ round(($fundRaiserPost->donates->sum('net_balance') * 100) / $fundRaiserPost->goal) }}%;"
                                    aria-valuenow="{{ round(($fundRaiserPost->donates->sum('net_balance') * 100) / $fundRaiserPost->goal) }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ round(($fundRaiserPost->donates->sum('net_balance') * 100) / $fundRaiserPost->goal) }}%
                                </div>
                            </div>
                            <ul class="fundraisers_card_bottom">
                                <li>{{ round(($fundRaiserPost->donates->sum('net_balance') * 100) / $fundRaiserPost->goal) }}%
                                    <span>Funded</span>
                                </li>
                                <li>${{ number_format($fundRaiserPost->goal, 2) }} <span>Target</span></li>
                                <li>{{ $fundRaiserPost->end_date->diffInDays() }} <span>Day Left</span></li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Fundraisers area end -->

    <!-- Trust & Safety -->
    <section id="trust">
        <div class="container">
            <div class="row">
                @isset($home2ColumnBlocks)
                    @foreach ($home2ColumnBlocks as $home2ColumnBlock)
                        <div class="col-lg-6">
                            <div class="trust_text">
                                <h3><i class="{{ $home2ColumnBlock->icon }}"></i> {{ $home2ColumnBlock->title }}</h3>
                                <p>{!! $home2ColumnBlock->description !!}</p>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </section>
    <!-- Trust & Safety end -->
@endsection
