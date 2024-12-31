@extends('layouts.frontapp')
@section('title', 'Fundraiser')
@section('content')
    <!-- breadcrumb  -->
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">iFundraiser</a></li>
                        <li class="breadcrumb-item active">Fundraiser</li>
                    </ol>
                </div>

            </div>
        </div>
    </section>
    <!-- breadcrumb end  -->


    <!-- Fundraisers area start -->
    <section id="fundraisers" class="fundraiser_page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_header">
                        <h2>Fundraisers</h2>
                        <div class="search_box w-50 d-none d-sm-block">
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
                                <a href="{{ route('front.fundraiser.post.show', $fundRaiserPost->slug) }}">
                                    <img src="{{ asset('storage/fundraiser_post/' . $fundRaiserPost->image) }}"
                                        alt="{{ $fundRaiserPost->title }}">
                                </a>
                            @else
                                <a href="{{ route('front.fundraiser.post.show', $fundRaiserPost->slug) }}">
                                    <img src="{{ Avatar::create($fundRaiserPost->title)->setBackground('#ddd')->setDimension(250)->setFontSize(16)->toBase64() }}"
                                        alt="{{ $fundRaiserPost->title }}">
                                </a>
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

    <!-- pagination  -->
    <section id="custom_pagination">
        <nav class="container mb-5">
            {{ $fundRaiserPosts->links() }}
            {{-- <ul class="d-flex justify-content-center">
                <li><a href="#">&laquo; Previous</a></li>
                <li><a class="active" href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">Next &raquo;</a></li>
            </ul> --}}
        </nav>
    </section>
    <!-- pagination end  -->
@endsection;
