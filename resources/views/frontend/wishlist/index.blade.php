@extends('layouts.clientapp')
@section('title', 'Wishlists')

@section('content')
    <div>
        <div class="account_content_area">
            <h3>Saved Fundraisers</h3>
            <div class="account_content_area_form">
                <form action="" method="GET" id="filterForm">
                    <div class="input-group">
                        <select class="form-select select2" name="title">
                            <option selected value="">All Fundraiser</option>
                            @foreach ($wishlists as $wishlist)
                                <option value="{{ $wishlist->fundraiser_post->id }}">{{ $wishlist->fundraiser_post->title }}
                                </option>
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
                            <th>Image</th>
                            <th>Fundraiser Title</th>
                            <th>Date</th>
                            <th style="text-align: right">Actions</th>
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
                order: [
                    [3, 'desc']
                ],
                ajax: {
                    url: '{{ route('wishlist.datatable') }}',
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
                        data: 'image',
                        name: 'image',
                        orderable: false
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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


            $(document).on('click', '.post_delete', function() {
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
            });
        });
    </script>

@endsection
