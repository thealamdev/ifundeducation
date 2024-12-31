@extends('layouts.frontapp')
@section('title', 'FAQs')
@section('content')
    <!-- breadcrumb  -->
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">iFundraiser</a></li>
                        <li class="breadcrumb-item active">FAQ</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end  -->

    <!-- faq part start -->
    <section id="page_block">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_header text-center">
                        <h2>{{$faqPage->sub_title}}</h2>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="text-center">
                        @isset ($faqPage->image)
                        <img class="img img-fuid" style="width: 100%;" src="{{ asset('frontend/images/pages/'.$faqPage->image) }}" alt="{{$faqPage->image}}">
                        @endisset
                    </div>
                </div>
            </div>
            <div class="row align-items-center about_row">
                @isset($faqPage->text_before_faq)
                <div class="col-md-12 mb-5">
                    {{$faqPage->text_before_faq}}
                </div>
                @endisset
                <div class="col-md-12">
                    @isset($faqs)
                    <div class="accordion " id="accordionFaq">
                        @foreach ($faqs as $faq)
                                <div class="accordion-item faq">
                                    <h2 class="accordion-header" id="heading{{$faq->id}}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{$faq->id}}">
                                            <i class="far fa-circle-question"></i> {{$faq->question}}
                                        </button>
                                    </h2>
                                    <div id="collapse{{$faq->id}}" class="accordion-collapse collapse {{$faq->id==1?'show':''}}"
                                        data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">
                                            <p>{!! $faq->answer !!}</p>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                    @endisset
                </div>
                @isset($faqPage->text_after_faq)
                <div class="col-md-12 my-5">
                    {{$faqPage->text_after_faq}}
                </div>
                @endisset
            </div>
        </div>
    </section>
    <!-- faq part end -->
@endsection
