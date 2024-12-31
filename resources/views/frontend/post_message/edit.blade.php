@extends('layouts.clientapp')
@section('title', 'Fundraiser Update Message')
@section('content')
    <div class="mb-5">
        <div class="account_content_area pr-0">
            <h3>Fundraiser Message Edit
                <a class="btn btn-sm btn-success float-end" href="{{ route('fundraiser.post.message.index') }}">Back</a>
            </h3>

            <form method="POST" action="{{ route('fundraiser.post.message.update', $fundraiserupdatemessage->id) }}"
                class="account_content_area_form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label d-block">Fundraising Post:<span class="text-danger">*</span></label>
                        <select name="fundraiser_post" id="fundraiser_post"
                            class="form-control @error('fundraiser_post') is-invalid @enderror">
                            <option disabled selected>Select Post</option>
                            @foreach ($posts as $post)
                                <option value="{{ $post->id }}"
                                    {{ $fundraiserupdatemessage->fundraiser_post_id === $post->id ? 'selected' : '' }}>
                                    {{ $post->title }}</option>
                            @endforeach
                        </select>
                        <p class="text-danger" id="fundraiser_postErrorMsg"></p>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="update_message" class="form-label">Message :<span class="text-danger">*</span></label>
                        <textarea class="form-control @error('update_message') is-invalid @enderror" id="update_message" name="update_message"
                            rows="10">{{ old('update_message', $fundraiserupdatemessage->message) }}</textarea>
                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px">Maximum 500 Character.
                        </p>
                        <p class="text-danger" id="update_messageErrorMsg"></p>
                    </div>

                    <div class="col-12">
                        <button type="submit">Update</button>
                    </div>
                </div>
            </form>


        </div>
    </div>

@endsection
