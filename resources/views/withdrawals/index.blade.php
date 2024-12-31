@extends('layouts.clientapp')
@section('title', 'Payout')

@section('content')
    <div class="mb-5">
        <div class="row">
            <div class="col-12">
                <div class="account_content_area">
                    <h3>Payout </h3>
                </div>
            </div>
            <div class="col-md-8">
                <div class="account_content_area pr-0">
                    <div class="account_content_area_form">
                        @if (!auth()->user()->stripe_account_id)
                            <div class="alert alert-info mt-3">
                                <p>Please, Setup Stripe Connect Account.</p>
                            </div>
                        @elseif ($payoutAttemptCount > 3)
                            <div class="alert alert-warning mt-3">
                                <p>Please try again later, as our system has made three payout attempts today.</p>
                            </div>
                        @elseif ($payoutRequest > 0)
                            <div class="alert alert-success mt-3">
                                <p>Your One Payout request is procecing.</p>
                            </div>
                        @else
                            <p>You currently have
                                <strong>${{ $balance->balance ? number_format($balance->balance->net_balance, 2) : '0' }}</strong>
                                in earnings for next payout.
                            </p>
                            <form action="{{ route('withdrawals.verify') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                                <button type="submit" class="btn btn-sm btn-success mt-3">Start
                                    Payout</button>
                            </form>
                        @endif

                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="account_content_area ps-0">
                    <div class="account_content_area_form ">
                        @if (auth()->user()->stripe_account_id)
                            <div>
                                <img src="{{ asset('frontend/images/stripe-logo-1.png') }}" width="120"
                                    alt="Stripe Logo">
                                <p><strong>Name</strong>: {{ $stripeAccount['display_name'] }}</p>
                                <p><strong>Email</strong>: {{ $stripeAccount['email'] }}</p>
                                <p><strong>Added</strong>: {{ $stripeAccount['connected_date'] }}</p>
                            </div>
                            <a target="_blank" href="{{ route('withdrawals.stripe.login') }}"
                                class="btn btn-success btn-sm">Login Stripe</a>
                        @else
                            <img src="{{ asset('frontend/images/stripe-logo-1.png') }}" width="120" alt="Stripe Logo">
                            <br>
                            <a href="{{ route('withdrawals.stripe.account') }}" class="btn btn-primary btn-sm mt-3">Set
                                Stripe Account</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="account_content_area">
                    <h3>Payout History</h3>
                    <div class="account_content_area_form">
                        <form action="" method="GET" id="filterForm">
                            <div class="input-group">
                                <select class="form-select" name="status">
                                    <option selected value="">All status</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="processing">Processing</option>
                                </select>
                                <input type="date" class="form-control" name="fromdate">
                                <div class="border">
                                    <label class="form-label  px-2 mb-0 pt-2">to</label>
                                </div>
                                <input type="date" class="form-control" name="todate">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="account_content_area_form">
                        <div>
                            <button type="button" class="btn btn-primary download_PDF_btn" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Export Report
                            </button>

                        </div>
                        <div class="table-responsive">
                            <table class="table" id="data-table">
                                <thead>
                                    <tr class="table-dark">
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{ route('download.payout.list') }}" method="GET">
            @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Donation List</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select class="form-select pdf_status" name="pdf_status">
                                    <option selected value="">All status</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="processing">Processing</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">From Date:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control pdf_fromdate" name="pdf_fromdate">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">To Date:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control pdf_todate" name="pdf_todate">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3">Column:</label>
                            <div class="col-sm-8">
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="payout_id_column"> id
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="amount_column"> Amount
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="date_column"> date
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="status_column"> status
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Download</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Payout Form -->
    {{-- <div class="modal fade modal-md show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="staticBackdropLabel">
                        Payout Request
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You currently have
                    <strong>{{ $balance->balance ? $balance->balance->curent_amount - $balance->balance->withdraw_amount : '0' }}</strong>
                    in earnings for next payout.
                    <form action="" method="POST" class="mt-3">
                        @csrf
                        <div class="mt-2">
                            <input type="text" class="form-control" placeholder="Payout Amount"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        </div>
                        <div class="mt-3">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            myModal.show();
        });
    </script> --}}




@endsection
@section('script')

    <script>
        $(function($) {

            //modal

            $('.download_PDF_btn').on('click', function() {
                var pdf_status = $('.pdf_status option');
                var selectedTitle = $('select[name=status]').val();
                pdf_status.each(function() {
                    var value = $(this).val();
                    if (selectedTitle == value) {
                        $(this).prop('selected', true);
                    } else {
                        $(this).prop('selected', false);
                    }
                });

                $('.pdf_fromdate').val($('input[name=fromdate]').val());
                $('.pdf_todate').val($('input[name=todate]').val());

            });


            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                order: [
                    [3, 'desc']
                ],
                ajax: {
                    url: '{{ route('withdrawals.index.datatable') }}',
                    type: "GET",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $('select[name=status]').val();
                        d.fromdate = $('input[name=fromdate]').val();
                        d.todate = $('input[name=todate]').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ]
            });
            $('#filterForm').on('submit', function(e) {
                dTable.draw();
                e.preventDefault();
            });
        });
    </script>

@endsection
