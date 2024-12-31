@extends('layouts.clientapp')
@section('title', 'Comments')

@section('content')
    <div>
        <div class="account_content_area">
            <h3>Comments</h3>
            <div class="account_content_area_form">
                <form action="{{ route('fundraiser.comment.index') }}" method="GET">
                    <div class="input-group">
                        <select class="form-select select2" name="title">
                            <option selected value="">All Fundraiser</option>
                            @foreach ($fundposts as $fundpost)
                                <option value="{{ $fundpost->id }}"
                                    {{ request()->title == $fundpost->id ? 'selected' : '' }}>{{ $fundpost->title }}
                                </option>
                            @endforeach
                        </select>
                        <select class="form-select" name="status">
                            <option value="">All</option>
                            <option value="approved" {{ request()->status == 'approved' ? 'selected' : '' }}>Approve
                            </option>
                            <option value="unapproved" {{ request()->status == 'unapproved' ? 'selected' : '' }}>Unapprove
                            </option>
                            <option value="blocked" {{ request()->status == 'blocked' ? 'selected' : '' }}>Blocked
                            </option>
                        </select>
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="account_content_area_form table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Comments</th>
                            <th>Fundraiser Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th style="text-align: right; width:15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse  ($comments as $key=>$comment)
                            <tr style="background: rgba(230, 229, 229, 0.7)">
                                <td>
                                    {{ $comment->comment }}

                                    <p style="font-size: 12px">{{ $comment->created_at->format('M d, Y') }}</p>
                                </td>
                                <td>{{ Str::limit($comment->fundraiserpost->title, 20, '...') }}</td>
                                <td>{{ $comment->name }} <br> {{ $comment->email }} </td>
                                <td><span
                                        class="badge  {{ $comment->status === 'approved' ? 'bg-success' : ($comment->status === 'blocked' ? 'bg-danger' : 'bg-warning') }}">{{ $comment->status }}</span><br>
                                    <span
                                        style="font-size: 11px">{{ $comment->status === 'blocked' ? 'by admin' : '' }}</span>
                                </td>
                                <td align="right">
                                    @if ($comment->status != 'blocked')
                                        <a href="#" data-id="{{ $comment->id }}"
                                            data-title=" {{ Str::limit($comment->comment, 20, '...') }}"
                                            data-postid="{{ $comment->fundraiser_post_id }}" class="action_icon replay_btn"
                                            title="Reply" data-bs-toggle="modal" data-bs-target="#replayModal">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                        <a href="{{ route('fundraiser.comment.status.update', $comment->id) }}"
                                            class="action_icon"
                                            title="{{ $comment->status === 'approved' ? 'Unapproved' : 'Approved' }}">
                                            <i
                                                class="far {{ $comment->status === 'approved' ? 'fa-circle-xmark' : 'fa-square-check' }}"></i>

                                        </a>
                                    @endif

                                    <form action="{{ route('fundraiser.comment.delete', $comment->id) }}" method="POST"
                                        class="d-inline" style="cursor: pointer">
                                        @csrf
                                        @method('DELETE')
                                        <p class="action_icon delete post_delete" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </p>
                                    </form>
                                </td>
                            </tr>
                            @foreach ($comment->replies as $key => $replie)
                                <tr>
                                    <td>
                                        <p style="font-size: 12px">In reply to: <strong>{{ $comment->name }}</strong></p>
                                        {{ $replie->comment }}
                                        <br>
                                        <p style="font-size: 12px">{{ $replie->created_at->format('M d, Y') }}</p>
                                    </td>
                                    <td>{{ Str::limit($comment->fundraiserpost->title, 20, '...') }}</td>
                                    <td>{{ $replie->name }} <br> {{ $replie->email }} </td>

                                    <td><span
                                            class="badge  {{ $replie->status === 'approved' ? 'bg-success' : ($comment->status === 'blocked' ? 'bg-danger' : 'bg-warning') }}">{{ $replie->status }}</span>
                                        <br> <span
                                            style="font-size: 11px">{{ $replie->status === 'blocked' ? 'by admin' : '' }}
                                        </span>
                                    </td>
                                    <td align="right">

                                        <a href="{{ route('fundraiser.comment.status.update', $replie->id) }}"
                                            class="action_icon"
                                            title="{{ $replie->status === 'approved' ? 'Unapproved' : 'Approved' }}">
                                            <i
                                                class="far {{ $replie->status === 'approved' ? 'fa-circle-xmark' : 'fa-square-check' }}"></i>

                                        </a>
                                        {{-- <a href="" class="action_icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a> --}}
                                        <form action="{{ route('fundraiser.comment.delete', $replie->id) }}" method="POST"
                                            class="d-inline" style="cursor: pointer">
                                            @csrf
                                            @method('DELETE')
                                            <p class="action_icon delete post_delete" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </p>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p>No Post Found!</p>
                                </td>
                            </tr>
                        @endforelse



                    </tbody>
                </table>
                <div>
                    {{ $comments->links() }}
                </div>
            </div>


        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="replayModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="replayTitle">Reply</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('fundraiser.comment.replay') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="replay_id" value="">
                        <textarea name="replay" id="" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Reply</button>
                    </div>
                </form>
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
        $('.select2').select2();
        $(function($) {

            $('.replay_btn').on('click', function() {
                let id = $(this).data("id");
                let title = $(this).data("title");
                $('#replayModal').find('#replay_id').val(id);
                $('#replayModal').find('#replayTitle').html(title);
            });

            $('.post_delete').on('click', function() {
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
