@extends('layouts.clientapp')
@section('title')
    {{ $fundraiserpost->title }}
@endsection

@section('content')
    <div class=" mb-5">

        <div class="account_content_area">
            <h3>{{ $fundraiserpost->title }}</h3>
            @if ($lastApprovedComment)
                @foreach ($lastApprovedComment as $lastApprovedComment)
                    @if ($lastApprovedComment->status != 'running' && $fundraiserpost->status != 'running')
                        <div class="alert alert-warning">
                            <div>
                                <strong>{{ $lastApprovedComment->created_at->format('M d, Y') }}</strong>
                                <hr>
                                <p>{{ $lastApprovedComment->comments }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

            <div class="account_content_area_form table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <tr>
                        <td width="20%"><strong>Raised</strong></td>
                        <td width="3%">:</td>
                        <td>${{ number_format($fundraiserpost->donates->sum('net_balance'), 2) }}</td>
                    </tr>
                    <tr>
                        <td width="20%"><strong>Status</strong></td>
                        <td width="3%">:</td>
                        <td><span
                                class="badge bg-{{ $fundraiserpost->status == 'running' || $fundraiserpost->status == 'completed' ? 'success' : ($fundraiserpost->status == 'pending' ? 'warning' : 'danger') }}">{{ Str::ucfirst($fundraiserpost->status) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><strong>Category</strong></td>
                        <td width="3%">:</td>
                        <td><span class="badge bg-success"> {{ $fundraiserpost->fundraisercategory->name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><strong>Goal</strong></td>
                        <td width="3%">:</td>
                        <td>${{ number_format($fundraiserpost->goal, 2) }}</td>
                    </tr>
                    <tr>
                        <td width="20%"><strong>End Date</strong></td>
                        <td width="3%">:</td>
                        <td>{{ $fundraiserpost->end_date->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td width="20%"><strong>Short Description</strong></td>
                        <td width="3%">:</td>
                        <td>{{ $fundraiserpost->shot_description }}</td>
                    </tr>
                    <tr>
                        <td width="20%" valign="top"><strong>Description</strong></td>
                        <td width="3%" valign="top">:</td>
                        <td>{!! $fundraiserpost->story !!}</td>
                    </tr>
                    <tr>
                        <td width="20%"><strong>Date Created</strong></td>
                        <td width="3%">:</td>
                        <td>{{ $fundraiserpost->created_at->format('M d, Y') }}</td>
                    </tr>

                </table>
            </div>

        </div>
        <div class="account_content_area mt-5">
            <h3>Donations:</h3>
            <div class="account_content_area_form table-responsive">
                <table class="table" id="donor_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Donation Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>

        </div>

        <div class="account_content_area mt-5">
            <h3>Comments:</h3>
            <div class="account_content_area_form table-responsive">
                <table class="table" id="comments_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>

        </div>
        <div class="account_content_area mt-5">
            <h3>Update Message:</h3>
            <div class="account_content_area_form table-responsive">
                <table class="table" id="message_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>message</th>
                            <th>date</th>
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
        var dTable = $('#donor_table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [
                [3, 'desc']
            ],
            ajax: {
                url: "{{ route('fundraiser.post.single.donation.datatable', $fundraiserpost->id) }}",
                type: "GET"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'donar_name',
                    name: 'donar_name'
                },
                {
                    data: 'net_balance',
                    name: 'net_balance'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ]
        });
        var dTable = $('#comments_table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [
                [5, 'desc']
            ],
            ajax: {
                url: "{{ route('fundraiser.post.single.comments.datatable', $fundraiserpost->id) }}",
                type: "GET"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },

                {
                    data: 'comment',
                    name: 'comment'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ]
        });

        var dTable = $('#message_table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: "{{ route('fundraiser.post.single.updatemessage.datatable', $fundraiserpost->id) }}",
                type: "GET"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'message',
                    name: 'message'
                }, {
                    data: 'created_at',
                    name: 'created_at'
                }
            ]
        });
    </script>
@endsection
