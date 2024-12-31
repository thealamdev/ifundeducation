@extends('layouts.backapp')
@section('title', 'Comments')
@section('breadcrumb')
    <div data-kt-place="true" data-kt-place-mode="prepend"
        data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
        class="page-title d-flex align-items-center me-3">
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-dark">Comments</li>
        </ul>
    </div>
@endsection


@section('content')
    <div class="card my-5">
        <div class="card-body">
            <form action="" method="GET" id="filterForm">
                <div class="row">

                    <div class="col-lg-3 px-0">
                        <select class="form-select" data-control="select2" data-hide-search="false" name="title">
                            <option value="">All running campaign</option>
                            @foreach ($fundposts as $fundpost)
                                <option value="{{ $fundpost->id }}">{{ $fundpost->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 px-0">
                        <select class="form-select" data-control="select2" data-hide-search="false" name="status">
                            <option value="">All</option>
                            <option value="approved">Approved</option>
                            <option value="unapproved">Unapproved</option>
                            <option value="blocked">Blocked</option>
                        </select>
                    </div>
                    <div class="col-lg-2 px-0">
                        <select class="form-select" data-control="select2" data-hide-search="false" name="admin_view">
                            <option value="">All</option>
                            <option value="read">Read</option>
                            <option value="unread">Unread</option>
                        </select>
                    </div>
                    <div class="col-lg-2 px-0">
                        <input type="date" class="form-control" name="fromdate">
                        <p class="text-gray-400">Start date</p>
                    </div>
                    <div class="col-lg-2 px-0">
                        <input type="date" class="form-control" name="todate">
                        <p class="text-gray-400">End date</p>
                    </div>
                    <div class="col-sm-2 col-lg-2 px-0">
                        <button class="btn btn-success" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">All Comments
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="data-table">
                    <thead>
                        <tr class="fw-bolder text-muted">
                            <th>ID</th>
                            <th>Comment</th>
                            <th>Campaign</th>
                            <th>Author</th>
                            <th>Date</th>
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
        $(function($) {
            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                // order: [
                //     [3, 'desc']
                // ],
                ajax: {
                    url: "{{ route('dashboard.campaign.comment.admin.all.comment.datatable') }}",
                    type: "GET",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.title = $('select[name=title]').val();
                        d.status = $('select[name=status]').val();
                        d.admin_view = $('select[name=admin_view]').val();
                        d.fromdate = $('input[name=fromdate]').val();
                        d.todate = $('input[name=todate]').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'comment',
                        name: 'comment',
                    },
                    {
                        data: 'campaign',
                        name: 'campaign',
                    },
                    {
                        data: 'author',
                        name: 'author'
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
                        name: 'admin_view'
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
        })
    </script>
@endsection
