@extends('layouts.frontapp')
@section('title', 'Contact')

@section('content')
    <!-- breadcrumb  -->
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">iFundraiser</a></li>
                        <li class="breadcrumb-item active">Contact</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end  -->

    <main id="contact">
        <section class="contact">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_header text-center">
                            <h2>{{ $contactPage->sub_title }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="row">
                            {{-- <div class="col-md-12">
                                <div class="info-box"> <i class="{{$contactPage->address_icon}}"></i>
                                    <h3>{{$contactPage->address_title}}</h3>
                                    <p>{!! $contactPage->address_text !!}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box"> <i class="{{$contactPage->email_icon}}"></i>
                                    <h3>{{$contactPage->email_title}}</h3>
                                    <p style="padding: 0 20px;">{{$contactPage->email_text}}</p>
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="info-box"> <i class="{{ $contactPage->phone_icon }}"></i>
                                    <h3>{{ $contactPage->phone_title }}</h3>
                                    <p style="padding: 0 86px;">{!! $contactPage->phone_text !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form action="{{ route('front.contact.store') }}" method="POST" class="contact_form"
                            id="contactUSForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="your_name" class="form-control" id="your_name"
                                        placeholder="Your Name" required="" value="{{ old('your_name') }}">
                                    @if ($errors->has('your_name'))
                                        <span class="text-danger">{{ $errors->first('your_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="your_email" id="your_email"
                                        placeholder="Your Email" required="" value="{{ old('your_email') }}">
                                    @if ($errors->has('your_email'))
                                        <span class="text-danger">{{ $errors->first('your_email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="subject" id="subject"
                                    placeholder="Subject" required="" value="{{ old('subject') }}">
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message" required="">{{ old('Message') }}</textarea>
                                @if ($errors->has('message'))
                                    <span class="text-danger">{{ $errors->first('message') }}</span>
                                @endif
                                @if ($errors->has('token'))
                                    <span class="text-danger">{{ $errors->first('token') }}</span>
                                @endif
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection;

@section('script')

    <script src="https://www.google.com/recaptcha/api.js"></script>


    @error('name')
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: "{{ $message }}",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                padding: '1em',
                customClass: {
                    'title': 'alert_title',
                    'icon': 'alert_icon',
                    'timerProgressBar': 'bg-danger',
                }
            })
        </script>
    @enderror
@endsection
