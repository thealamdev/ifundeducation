@extends('layouts.clientapp')
@section('title', 'withdrawals')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="account_content_area">
                    <h3>Payout Request</h3>
                </div>
            </div>
            <div class="col-md-8">
                <div class="account_content_area">
                    <div class="account_content_area_form">

                        You currently have
                        <strong>{{ $balance->balance->net_balance }}</strong>
                        in earnings for next payout.
                        <form action="{{ route('withdrawals.payout.request') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="mt-2">
                                <input type="text" name="amount" class="form-control" placeholder="Payout Amount"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                @error('amount')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
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
