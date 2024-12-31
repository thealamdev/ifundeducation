@extends('layouts.frontapp')
@section('title', $commonPage->title)
@section('content')
    <!-- breadcrumb  -->
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">iFundraiser</a></li>
                        <li class="breadcrumb-item active">{{$commonPage->title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end  -->

    <section id="page_block">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_header text-center">
                        <h2>{{$commonPage->title}}</h2>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="text-center">
                        @isset ($commonPage->image)
                        <img class="img img-fuid" style="width: 100%;" src="{{ asset('frontend/images/pages/'.$commonPage->image) }}" alt="{{$commonPage->image}}">
                        @endisset
                    </div>
                </div>
            </div>
            <div class="row align-items-center about_row">
                <div class="col-md-12">
                    <div class="about_page_content">
                        {!! $commonPage->long_description !!}
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection;
