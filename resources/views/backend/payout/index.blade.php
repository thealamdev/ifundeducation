@extends('layouts.backapp')
@section('title', 'Payouts List')
@section('breadcrumb')
    <div data-kt-place="true" data-kt-place-mode="prepend"
        data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
        class="page-title d-flex align-items-center me-3">
        <!--begin::Title-->
        <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Payouts List</h1>
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
            <li class="breadcrumb-item text-dark">Payouts List</li>
        </ul>
    </div>
@endsection
@section('content')
    {{-- <div class="card mb-5">
        <div class="card-body">
            <form action="" method="GET" id="filterForm">
                <div class="input-group">
                    <select class="form-select select2" name="title">
                        <option selected value="">Running Fundraiser</option>
                        @foreach ($fundposts as $fundpost)
                            <option value="{{ $fundpost->id }}">{{ $fundpost->title }}</option>
                        @endforeach
                    </select>
                    <div class="border">
                        <label class="form-label  px-2 mb-0 pt-2">Start date</label>
                    </div>
                    <input type="date" class="form-control" name="fromdate">
                    <div class="border">
                        <label class="form-label  px-2 mb-0 pt-2">End date</label>
                    </div>
                    <input type="date" class="form-control" name="todate">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div> --}}
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Payouts</span>
            </h3>

        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="data-table">
                    <!--begin::Table head-->
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Email</th>
                            <th>Amount</th>
                            <th>Created</th>
                            <th>Status</th>
                            <th>Read/unread</th>
                            <th class="text-end">Actions</th>
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
        $(function() {
            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('dashboard.fundraiser.payout.list.datatable') }}",
                    type: "GET",
                    // data: function(d) {
                    //     d._token = "{{ csrf_token() }}";
                    //     d.title = $('select[name=title]').val();
                    //     d.fromdate = $('input[name=fromdate]').val();
                    //     d.todate = $('input[name=todate]').val();
                    // }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'admin_view',
                        name: 'admin_view',
                    },
                    {
                        data: 'action_column',
                        name: 'action_column'
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
