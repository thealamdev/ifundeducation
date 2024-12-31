@extends('layouts.backapp')
@section('title', 'Payout Report')
@section('breadcrumb')
    <div data-kt-place="true" data-kt-place-mode="prepend"
        data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
        class="page-title d-flex align-items-center me-3">
        <!--begin::Title-->
        <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Payout Report</h1>
        <!--end::Title-->
        <!--begin::Separator-->
        <span class="h-20px border-gray-200 border-start mx-4"></span>
        <!--end::Separator-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Report</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Search Report</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <form action="" method="POST" id="filterForm">
                @csrf
                <div class="row">
                    <div class="col-md-4 col-lg-3 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Fundraiser</label>
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                            data-placeholder="Select Fundraiser" name="user">
                            <option value="">All</option>
                            @foreach ($fundraisers as $fundraiser)
                                <option value="{{ $fundraiser->id }}">
                                    {{ $fundraiser->first_name . ' ' . $fundraiser->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 col-lg-2 fv-row">
                        <label class=" fs-6 fw-bold mb-2">Status</label>
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                            name="status">
                            <option value="">All</option>
                            <option value="transfer">Transfer</option>
                            <option value="processing">Processing</option>
                        </select>
                    </div>
                    <div class="col-lg-2 px-0">
                        <label class=" fs-6 fw-bold mb-2">Transfer form Date</label>
                        <input type="date" class="form-control" name="fromdate">
                    </div>
                    <div class="col-lg-2 px-0">
                        <label class=" fs-6 fw-bold mb-2"> Transfer to Date</label>
                        <input type="date" class="form-control" name="todate">
                    </div>

                </div>
                <div class="mt-2">
                    <button type="submit" id="search_submit" class="btn btn-primary btn-sm">
                        <span class="indicator-label">Submit</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Payout Report</span>
            </h3>
            <div>
                <form action="{{ route('dashboard.report.payout.export.excel') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id">
                    <input type="hidden" name="status">
                    <input type="hidden" name="transfer_from_date">
                    <input type="hidden" name="transfer_to_date">
                    <button type="submit" class="btn btn-primary btn-sm">Export Excel</button>
                </form>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="data-table">
                    <thead>
                        <tr class="fw-bolder text-muted">
                            <th>Id</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Request Date</th>
                            <th>Transaction Id</th>
                            <th>Destination</th>
                            <th>Currency</th>
                            <th>Transfer Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function($) {

            $('#search_submit').on('click', function() {
                let user_id = $('input[name=user_id]');
                let status = $('input[name=status]');
                let transfer_from_date = $('input[name=transfer_from_date]');
                let transfer_to_date = $('input[name=transfer_to_date]');

                user_id.val($('select[name=user]').val());
                status.val($('select[name=status]').val());
                transfer_from_date.val($('input[name=fromdate]').val());
                transfer_to_date.val($('input[name=todate]').val());
            });

            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                ajax: {
                    url: "{{ route('dashboard.report.payout.list.datatable') }}",
                    type: "GET",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.status = $('select[name=status]').val();
                        d.user = $('select[name=user]').val();
                        d.fromdate = $('input[name=fromdate]').val();
                        d.todate = $('input[name=todate]').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'author',
                        name: 'author',
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'balance_transaction',
                        name: 'balance_transaction'
                    },
                    {
                        data: 'destination',
                        name: 'destination'
                    },
                    {
                        data: 'currency',
                        name: 'currency'
                    },
                    {
                        data: 'transaction_time',
                        name: 'transaction_time'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    }
                ]
            });

            $('#filterForm').on('submit', function(e) {
                dTable.draw();
                e.preventDefault();
            });
        })
    </script>
@endsection
