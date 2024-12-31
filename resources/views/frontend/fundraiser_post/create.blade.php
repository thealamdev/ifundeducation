@extends('layouts.clientapp')
@section('title', 'Start Fundraiser')

@section('content')
    <div class="mb-5">
        <div class="account_content_area">
            <h3>Start a Fundraiser</h3>
            <form method="POST" action="{{ route('fundraiser.post.store') }}" class="account_content_area_form p-4 pb-5"
                enctype="multipart/form-data" id="post_form">
                @csrf
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="fund_title" class="form-label">Fundraiser Title:<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="fund_title"
                            name="title" value="{{ old('title') }}">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px">Maximum 100 Character.
                        </p>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="shot_description" class="form-label">Short Description:<span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('shot_description') is-invalid @enderror" id="shot_description"
                            name="shot_description" rows="5">{{ old('shot_description') }}</textarea>
                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px">Maximum 250 Character.
                        </p>
                        @error('shot_description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="goal" class="form-label">Fundraising Goal:<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fas fa-dollar"></i>
                            </div>
                            <input type="number" class="form-control @error('goal') is-invalid @enderror" id="goal"
                                name="goal" value="{{ old('goal') }}">
                        </div>
                        @error('goal')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="" class="form-label">Fundraising End Date:<span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                            id="date" value="{{ old('end_date') }}" placeholder="mm/dd/yy">
                        @error('end_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label d-block">Fundraising For:<span class="text-danger">*</span></label>
                        <select name="category" id=""
                            class="form-control select_2 @error('category') is-invalid @enderror">
                            <option disabled>Select Options</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="story" class="form-label">Tell Your Story :</label>
                        <textarea class="form-control @error('story') is-invalid @enderror" id="story" name="story">{{ old('story') }}</textarea>
                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px">Maximum 1500 Character.
                        </p>
                        @error('story')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Add Image :</label>
                        <input class="form-control @error('image') is-invalid @enderror" name="image" type="file">
                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px"> Image ratio 250x250px
                            and
                            maximum image size 300kb.
                        </p>
                        @error('image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input @error('agree') is-invalid @enderror" type="checkbox"
                                    name="agree"> I agree
                                to the
                                <a href="{{ config('app.url') }}/page/terms-conditions" target="_blank">terms &amp;
                                    conditions</a>
                            </label>
                        </div>
                        @error('agree')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit"
                            onclick="this.form.submit(); this.disabled=true; this.innerHTML='saving…';">Publish</button>
                        <input type="hidden" name="save_draft" id="draft_input">
                        <button type="button" name="save_draft" id="draft_btn">Save to
                            draft</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script>
        $(document).on('click', '#draft_btn', function() {
            $('#draft_input').val('draft');
            $('#post_form').submit();
            this.disabled = true;
            this.innerHTML = 'saving…';
        });

        $('.select_2').select2();
        //editor
        ClassicEditor
            .create(document.querySelector('#story'), {
                ckfinder: {
                    uploadUrl: '{{ route('fundraiser.post.story.photo.upload') . '?_token=' . csrf_token() }}',
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
