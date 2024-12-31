@extends('layouts.frontapp')
@section('title', 'Terms and Condition')
@section('content')
    <!-- breadcrumb  -->
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">iFundraiser</a></li>
                        <li class="breadcrumb-item active">Terms & Conditions</li>
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
                        <h2>{{$terms->title}}</h2>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="text-center">
                        @isset ($terms->image)
                        <img class="img img-fuid" style="width: 100%;" src="{{ asset('frontend/images/pages/'.$terms->image) }}" alt="{{$terms->image}}">
                        @endisset
                    </div>
                </div>
            </div>
            <div class="row align-items-center terms_row">
                <div class="col-md-12">
                    <div class="terms_page_content">
                        {!! $terms->long_description !!}
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
