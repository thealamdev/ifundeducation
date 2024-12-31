@extends('layouts.backapp')
@section('title', 'Campaign Report')
@section('breadcrumb')
    <div data-kt-place="true" data-kt-place-mode="prepend"
        data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
        class="page-title d-flex align-items-center me-3">
        <!--begin::Title-->
        <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Campaign Report</h1>
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
            <form action="" method="GET" id="filterForm">

                <div class="row">
                    <div class="col-md-4 col-lg-3 fv-row">
                        <label class=" fs-6 fw-bold mb-2">Fundraiser</label>
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                            name="user">
                            <option value="">All</option>
                            @foreach ($fundraisers as $fundraiser)
                                <option value="{{ $fundraiser->id }}">
                                    {{ $fundraiser->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-3 fv-row">
                        <label class=" fs-6 fw-bold mb-2">Campaign</label>
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                            name="title">
                            <option value="">All</option>
                            @foreach ($campaigns as $campaign)
                                <option value="{{ $campaign->id }}">{{ $campaign->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-2 fv-row">
                        <label class=" fs-6 fw-bold mb-2">Status</label>
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="false"
                            name="status">
                            <option value="">All</option>
                            <option value="running">Running</option>
                            <option value="block">Blocked</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="col-lg-2 px-0">
                        <label class=" fs-6 fw-bold mb-2">Start Date</label>
                        <input type="date" class="form-control" name="fromdate">
                    </div>
                    <div class="col-lg-2 px-0">
                        <label class=" fs-6 fw-bold mb-2">End date</label>
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
                <span class="card-label fw-bolder fs-3 mb-1">Campaign Report</span>
            </h3>
            <div>
                <form action="{{ route('dashboard.report.campaign.export.excel') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id">
                    <input type="hidden" name="campaign_id">
                    <input type="hidden" name="search_status">
                    <input type="hidden" name="from_date">
                    <input type="hidden" name="to_date">
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
                            <th>Campaign</th>
                            <th>Goal</th>
                            <th>Status</th>
                            <th>End Date</th>
                            <th>Created At</th>
                            <th>Total Raised</th>
                            <th>Stripe Fee</th>
                            <th>Platform Fee</th>
                            <th>Net Amount</th>
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
                let campaign_id = $('input[name=campaign_id]');
                let search_status = $('input[name=search_status]');
                let from_date = $('input[name=from_date]');
                let to_date = $('input[name=to_date]');

                user_id.val($('select[name=user]').val());
                campaign_id.val($('select[name=title]').val());
                search_status.val($('select[name=status]').val());
                from_date.val($('input[name=fromdate]').val());
                to_date.val($('input[name=todate]').val());
            });

            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                // order: [
                //     [3, 'desc']
                // ],
                ajax: {
                    url: "{{ route('dashboard.report.campaign.list.datatable') }}",
                    type: "GET",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.title = $('select[name=title]').val();
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
                        data: 'campaign',
                        name: 'campaign',
                    },
                    {
                        data: 'gole',
                        name: 'gole'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },

                    {
                        data: 'donates_sum_amount',
                        name: 'donates_sum_amount'
                    },
                    {
                        data: 'donates_sum_stripe_fee',
                        name: 'donates_sum_stripe_fee'
                    },
                    {
                        data: 'donates_sum_platform_fee',
                        name: 'donates_sum_platform_fee'
                    },
                    {
                        data: 'donates_sum_net_balance',
                        name: 'donates_sum_net_balance'
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
