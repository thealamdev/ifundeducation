@extends('layouts.frontapp')

@section('title', $fundPost->title)

@section('content')
    <!-- breadcrumb  -->
    <section class="breadcrumb_section"
        style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('front.index') }}">{{ config('app.name') }}</a></li>
                        <li class="breadcrumb-item active">{{ $fundPost->title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end  -->

    <section id="fundraisers" class="fundraiser_page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form method="POST" action="{{ route('front.donate.post') }}" id="payment-form"
                        class="account_content_area_form">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $fundPost->id }}">

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">

                                @if ($fundPost->image)
                                    <img src="{{ asset('storage/fundraiser_post/' . $fundPost->image) }}" width="100"
                                        class="rounded" alt="{{ $fundPost->title }}">
                                @else
                                    <img src="{{ Avatar::create($fundPost->title)->setShape('square')->setBackground('#ddd')->setDimension(100)->setFontSize(12) }}"
                                        alt="{{ $fundPost->title }}" class="rounded">
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4>{{ $fundPost->title }}</h4>
                                <p>{{ $fundPost->shot_description }}</p>
                            </div>
                        </div>
                        <div class="border-top mb-3"></div>
                        <div class='col-12 mb-3'>
                            <div class="form-floating">
                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                    id="amount" name="amount" placeholder='Amount' value="{{ old('amount') }}"
                                    required>
                                <label for="amount">Amount</label>
                            </div>
                            @error('amount')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="border-top mb-3"></div>
                        <div class="row">
                            <div class='col-12 mb-3'>
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="name@example.com"
                                        value="{{ old('email') }}" required>
                                    <label for="email">Email</label>
                                </div>
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class='col-12 mb-3'>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Name" value="{{ old('name') }}"
                                        required>
                                    <label for="name">Name</label>
                                </div>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class='col-12 mb-3'>
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('cardNumber') is-invalid @enderror"
                                        id="cardNumber" name="cardNumber" placeholder="Card Number" maxlength="19"
                                        value="{{ old('cardNumber') }}" required>
                                    <label for="cardNumber">Card Number</label>
                                </div>
                                @error('cardNumber')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class='row mb-3'>
                                    <div class='col-md-4'>
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('cardCVC') is-invalid @enderror" id="cardCVC"
                                                name="cardCVC" placeholder='ex. 311' maxlength="3" pattern="[0-9]*"
                                                value="{{ old('cardCVC') }}" required>
                                            <label for="cardCVC">CVC</label>
                                        </div>
                                        @error('cardCVC')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class='col-md-4'>
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('expiraMonth') is-invalid @enderror"
                                                id="expiraMonth" name="expiraMonth" placeholder='MM' maxlength="2"
                                                value="{{ old('expiraMonth') }}" required>
                                            <label for="expiraMonth">Month</label>
                                        </div>
                                        @error('expiraMonth')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class=' col-md-4'>
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('expiraYear') is-invalid @enderror"
                                                id="expiraYear" name="expiraYear" placeholder='YYYY' maxlength="2"
                                                value="{{ old('expiraYear') }}" required>
                                            <label for="expiraYear">Year</label>
                                        </div>
                                        @error('expiraYear')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class='row mb-3'>
                                    <div class='col-md-6'>
                                        <div class="form-floating">
                                            <select class="form-select @error('country') is-invalid @enderror"
                                                name="country" id="floatingSelect" required>
                                                <option selected disabled>Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="floatingSelect">Country</label>
                                        </div>
                                        @error('country')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>
                                    <div class='col-md-6'>
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('zipCode') is-invalid @enderror" id="zipCode"
                                                name="zipCode" placeholder='Zip Code' value="{{ old('zipCode') }}"
                                                required>
                                            <label for="zipCode">Zip</label>
                                        </div>
                                        @error('zipCode')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                            <div>
                                <h6>Your donation</h6>
                                <div class="d-flex justify-content-between mt-3">
                                    <div>
                                        <p>Your donation</p>
                                    </div>
                                    <div>$ <span class="display_amount">0.00</span> </div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div>
                                        <p>Platform Fee</p>
                                    </div>
                                    <div>$ <span class="display_platform_fee">0.00</span></div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mt-2">
                                    <div>
                                        <strong>Total</strong>
                                    </div>
                                    <div>$ <span class="display_total">0.00</span></div>
                                </div>
                            </div>
                            <div class='col-12 mb-3 mt-3'>
                                <label> <input type="checkbox" name="is_display_info"> Don't display my name publicly on
                                    the
                                    fundraiser.</label>
                                @error('is_display_info')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Donate Now</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>



@endsection

@section('script')
    <script>
        $('#cardNumber').keyup(function() {
            cc = $(this).val().split("-").join("");

            cc = cc.match(new RegExp('.{1,4}$|.{1,4}', 'g')).join("-");

            $(this).val(cc);

        });

        $(document).ready(function() {

            const format = (num, decimals) => num.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

            let amount = $('#amount'),
                display_amount = $('.display_amount'),
                display_platform_fee = $('.display_platform_fee'),
                display_total = $('.display_total');

            amount.on('change', function() {
                let fee = parseFloat((amount.val() * 3.5) / 100);
                let user_amount = parseInt(amount.val());
                amount.val(user_amount);
                display_amount.html(user_amount);
                display_platform_fee.html(format(fee));
                display_total.html(user_amount + parseFloat(format(fee)));

            })



        });
    </script>
@endsection
