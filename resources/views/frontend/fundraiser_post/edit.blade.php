@extends('layouts.clientapp')
@section('title', $fundraiserpost->title)

@section('content')
    <div class="mb-5">
        <div class="account_content_area">
            <h3>Edit Fundraiser</h3>

            @if ($fundraiserpost->pendingUpdate)
                <div class="alert alert-warning">
                    <p>One update request pending!</p>
                </div>
            @endif

            <form method="POST" action="{{ route('fundraiser.post.update', $fundraiserpost->slug) }}"
                class="account_content_area_form" enctype="multipart/form-data" id="post_form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="fund_title" class="form-label">Fundraiser Title:<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="fund_title"
                            name="title" value="{{ old('title', $fundraiserpost->title) }}">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="shot_description" class="form-label">Short Description:<span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('shot_description') is-invalid @enderror" id="shot_description"
                            name="shot_description" rows="5">{{ old('shot_description', $fundraiserpost->shot_description) }}</textarea>
                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px">Maximum 250
                            Character.
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
                                name="goal" value="{{ old('goal', (int) $fundraiserpost->goal) }}">
                        </div>
                        @error('goal')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="" class="form-label">Fundraising End Date:<span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                            id="date" value="{{ old('end_date', $fundraiserpost->end_date->format('Y-m-d')) }}"
                            placeholder="mm/dd/yy">
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
                                <option value="{{ $category->id }}"
                                    {{ $fundraiserpost->fundraisercategory->id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="story" class="form-label">Tell Your Story :</label>
                        <textarea class="form-control @error('story') is-invalid @enderror" id="story" name="story">{{ old('story', $fundraiserpost->story) }}</textarea>
                        <p style="color: rgba(54, 76, 102, 0.7);  font-size: 13px">Maximum 1500 Character.
                        </p>
                        @error('story')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Add Image :</label>
                        <input class="form-control @error('image') is-invalid @enderror" name="image" type="file"
                            id="file_input">
                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px">Image ratio 250x250px
                            and
                            maximum image size 300kb.
                        </p>
                        @error('image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <div class="mt-2">
                            <img src="{{ asset('storage/fundraiser_post/' . $fundraiserpost->image) }}" id="show_img"
                                alt="" width="100">
                        </div>
                    </div>
                    <div class="col-12">

                        @if ($fundraiserpost->status === 'draft')
                            <input type="hidden" name="publish" id="publish_input">
                            <button type="submit" id="publish_btn">Publish</button>
                            <input type="hidden" name="save_draft" id="draft_input">
                            <button type="button" name="save_draft" id="draft_btn">Save to draft</button>
                        @else
                            @if (!$fundraiserpost->pendingUpdate)
                                <button type="submit"
                                    onclick="this.form.submit(); this.disabled=true; this.innerHTML='saving…';">Update</button>
                            @endif
                        @endif

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
        $(document).on('click', '#publish_btn', function() {
            $('#publish_input').val('publish');
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

        //image change
        let imgf = document.getElementById("file_input");
        let output = document.getElementById("show_img");

        imgf.addEventListener("change", function(event) {
            let tmppath = URL.createObjectURL(event.target.files[0]);
            output.src = tmppath;
        });
    </script>
@endsection
