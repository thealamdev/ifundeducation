@extends('layouts.clientapp')
@section('title', 'Donation List')

@section('content')
    <div class="mb-5">
        <div class="account_content_area">
            <h3>Total Donations</h3>
            <div class="account_content_area_form">
                <form action="" method="GET" id="filterForm">
                    <div class="input-group">
                        <select class="form-select select2" name="title">
                            <option selected value="">All Fundraiser</option>
                            @foreach ($fundposts as $fundpost)
                                <option value="{{ $fundpost->id }}">{{ $fundpost->title }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control"name="donorname" placeholder="Donor name">
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
                            <tr>
                                <th>#</th>
                                <th>Campaign</th>
                                <th>Payment Fee</th>
                                <th>Net Amount</th>
                                <th>Date</th>
                                <th>Donor</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{ route('donate.donation.list') }}" method="GET">
            @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Donation List</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Campaign</label>
                            <div class="col-sm-8">
                                <select class="form-select pdf_title" name="pdf_title">
                                    <option value="">All Campaign</option>
                                    @foreach ($fundposts as $fundpost)
                                        <option value="{{ $fundpost->id }}">{{ $fundpost->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Donor name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control pdf_donorname"name="pdf_donorname"
                                    placeholder="Donor name">
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
                                    <input type="checkbox" name="campaign_id"> id
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="campaign_title"> Campaign Title
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="stripe_fee"> Payment Fee
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="amount"> Amount
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="date"> date
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="donor"> donor
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
@endsection
@section('style')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection
@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(function($) {
            //modal

            $('.download_PDF_btn').on('click', function() {
                var pdf_title = $('.pdf_title option');
                var selectedTitle = $('select[name=title]').val();
                pdf_title.each(function() {
                    var value = $(this).val();
                    if (selectedTitle == value) {
                        $(this).prop('selected', true);
                    } else {
                        $(this).prop('selected', false);
                    }
                });

                $('.pdf_donorname').val($('input[name=donorname]').val());
                $('.pdf_fromdate').val($('input[name=fromdate]').val());
                $('.pdf_todate').val($('input[name=todate]').val());

            });

            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                order: [
                    [3, 'desc']
                ],
                ajax: {
                    url: "{{ route('donate.index.datatable') }}",
                    type: "GET",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.title = $('select[name=title]').val();
                        d.donorname = $('input[name=donorname]').val();
                        d.fromdate = $('input[name=fromdate]').val();
                        d.todate = $('input[name=todate]').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: 'stripe_fee',
                        name: 'stripe_fee'
                    },
                    {
                        data: 'net_balance',
                        name: 'net_balance'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'donor',
                        name: 'donor'
                    }
                ]
            });
            $('#filterForm').on('submit', function(e) {
                dTable.draw();
                e.preventDefault();
            });
        });

        $('.select2').select2();
    </script>

@endsection
