@extends('layouts.clientapp')
@section('title', 'Funding Posts')

@section('content')


    <div>
        <div class="account_content_area">
            <h3>My Fundraisers</h3>
            <div>
                <x-campaignbutton />
            </div>
            <div class="account_content_area_form">
                <form action="" method="GET" id="filterForm">
                    <div class="input-group">
                        <select class="form-select select2" name="title">
                            <option selected value="">Block Fundraiser</option>
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
                                <th>Id</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Target</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th style="text-align: right">Actions</th>
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
        <form action="{{ route('fundraiser.post.download.campaign.list') }}" method="GET">
            @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Running Campaign</h1>
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
                            <label class="col-sm-3 col-form-label">Start Date:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control start_date" name="start_date">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">To Date:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control to_date" name="to_date">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3 col-form-label">Status:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-secondary bg-opacity-50" name="status"
                                    value="block" readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-3">Column:</label>
                            <div class="col-sm-8">
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="campaign_id_column"> id
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="campaign_title_column"> Campaign Title
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="start_date_column"> Start Date
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="end_date_column"> End Date
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="status_column"> Status
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="target_column"> Target
                                </label>
                                <label class="me-2 d-inline-block">
                                    <input type="checkbox" name="raised_column"> Raised
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
            $('.select2').select2();

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

                $('.start_date').val($('input[name=fromdate]').val());
                $('.to_date').val($('input[name=todate]').val());
            });

            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('fundraiser.post.campaign.block.datatable') }}",
                    type: "GET",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.title = $('select[name=title]').val();
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
                        name: 'title'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'goal',
                        name: 'goal',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'status',
                        name: 'status',
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


            $('.running_campaign').on('click', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Restart this Fundraiser!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Running It!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            })
            $('.stop_campaign').on('click', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    text: "Stop this Fundraiser!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Stop It!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            })

            $(document).on('click', '.post_delete', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent('form').submit();
                    }
                });
            })
        });
    </script>

@endsection
