@extends('layouts.clientapp')
@section('title', 'Fundraiser Update Message')
@section('content')
    <div>
        <div class="account_content_area">
            <h3>Fundraiser Updates
                <button class="btn btn-sm btn-success float-lg-end mt-2 mt-sm-0 " data-bs-toggle="modal"
                    data-bs-target="#post_update_message">Post an Update + </button>
            </h3>

            <div class="account_content_area_form">
                <form action="" method="GET" id="filterForm">
                    <div class="input-group">
                        <select class="form-select select2" name="title">
                            <option selected value="">All Fundraiser</option>
                            @foreach ($fundposts as $fundpost)
                                <option value="{{ $fundpost->id }}">{{ $fundpost->title }}</option>
                            @endforeach
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
            <div class="account_content_area_form table-responsive">
                <table class="table" id="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fundraiser Title</th>
                            <th>Message</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Status</th>
                            <th style="text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="post_update_message" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Post an Update</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="account_content_area_form" id="update_message_post_form">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label d-block">Fundraiser:<span class="text-danger">*</span></label>
                                <select name="fundraiser_post" id="fundraiser_post"
                                    class="form-control @error('fundraiser_post') is-invalid @enderror">
                                    <option disabled selected>Select Fundraiser</option>
                                    @foreach ($fundposts as $post)
                                        <option value="{{ $post->id }}">{{ $post->title }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger" id="fundraiser_postErrorMsg"></p>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="update_message" class="form-label">Message :<span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('update_message') is-invalid @enderror" id="update_message" name="update_message"
                                    rows="5">{{ old('update_message') }}</textarea>
                                <p style="color: rgba(54, 76, 102, 0.7)">Maximum 500 Character.
                                </p>
                                <p class="text-danger" id="update_messageErrorMsg"></p>
                            </div>

                            <div class="col-12">
                                <button type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection
@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(function($) {

            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                order: [
                    [4, 'desc']
                ],
                ajax: {
                    url: '{{ route('fundraiser.post.message.index.datatable') }}',
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
                        name: 'title',
                        orderable: false
                    },
                    {
                        data: 'message',
                        name: 'message'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('#filterForm').on('submit', function(e) {
                dTable.draw();
                e.preventDefault();
            });


            $(document).on('click', '.message_delete', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
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

        $('.select2').select2();

        $('#update_message_post_form').on('submit', function(e) {
            e.preventDefault();

            let fundraiser_post = $('#fundraiser_post').val();
            let update_message = $('#update_message').val();


            $.ajax({
                url: "{{ route('fundraiser.post.message.store') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    fundraiser_post: fundraiser_post,
                    update_message: update_message,
                },
                success: function(response) {
                    if (response.success) {
                        $('#post_update_message').modal('hide');
                        document.location.href = "{{ route('fundraiser.post.message.index') }}";
                    }

                },
                error: function(response) {
                    $('#fundraiser_postErrorMsg').text(response.responseJSON.errors.fundraiser_post);
                    $('#update_messageErrorMsg').text(response.responseJSON.errors.update_message);
                },
            });
        });
    </script>

@endsection
