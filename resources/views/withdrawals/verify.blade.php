@extends('layouts.clientapp')
@section('title', 'withdrawals Verification')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="account_content_area">
                    <h3>Submit Verification Code</h3>
                </div>
            </div>
            <div class="col-md-8">
                <div class="account_content_area">
                    <div class="account_content_area_form">
                        <p>Check your email get the code and submit.</p>
                        <form action="{{ route('withdrawals.verify.code.submit') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="mt-2">
                                <input type="text" name="code" class="form-control" placeholder="Code"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                @error('code')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <p class="mt-2">Use This code within 2 min!</p>
                            <div id="countdown"></div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
