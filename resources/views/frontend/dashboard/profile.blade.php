@extends('layouts.clientapp')
@section('title', 'User Profile')

@section('content')
    <div class="mb-5">
        <div class="account_content_area">
            <h3>My Profile</h3>

            <div class="row">
                <div class="col-12 mb-4">
                    <ul class="nav nav-tabs" id="fundeducationTab">
                        <li class="nav-item">
                            <a href="#personal_profile" class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#personal_profile" type="button">Personal Profile</a>
                        </li>
                        @if (auth()->user()->hasRole('fundraiser'))
                            <li class="nav-item">
                                <a href="#academic_profile" class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#academic_profile" type="button">Academic Profile</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="#social_profile" class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#social_profile">Social Profile</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="personal_profile">
                        <form method="POST" action="{{ route('user.profile.personal.update', auth()->user()->id) }}"
                            class="account_content_area_form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="fname" class="form-label">First Name:<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('fname') is-invalid @enderror"
                                        value="{{ old('fname', auth()->user()->first_name) }}" id="fname"
                                        name="fname">
                                    @error('fname')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="lname" class="form-label">Last Name:</label>
                                    <input type="text" class="form-control @error('lname') is-invalid @enderror"
                                        value="{{ old('lname', auth()->user()->last_name) }}" id="lname" name="lname">
                                    @error('lname')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="email" class="form-label">E-mail:</label>
                                    <input type="email" value="{{ auth()->user()->email }}"
                                        class="form-control @error('email') is-invalid @enderror" id="email" disabled>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="phone" class="form-label">Phone:<span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="phone"
                                        value="{{ auth()->user()->personal_profile->phone ?? '' }}"
                                        class="form-control @error('phone') is-invalid @enderror" id="phone">
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="date" class="form-label">Date of Birth:<span
                                            class="text-danger">*</span></label>
                                    <input type="date"
                                        value="{{ !empty(auth()->user()->personal_profile) ? auth()->user()->personal_profile->birthday->format('Y-m-d') ?? '' : '' }}"
                                        class="form-control @error('birthday') is-invalid @enderror" id="date"
                                        name="birthday">
                                    @error('birthday')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Gender:<span class="text-danger">*</span></label>
                                    <br>

                                    <label>
                                        <input type="radio" name="gender" value="male"
                                            {{ !empty(auth()->user()->personal_profile) && auth()->user()->personal_profile->gender === 'male' ? 'checked' : '' }}>
                                        Male
                                    </label>:
                                    <label class="ms-2 d-inline-block">
                                        <input type="radio" name="gender" value="female"
                                            {{ !empty(auth()->user()->personal_profile) && auth()->user()->personal_profile->gender === 'female' ? 'checked' : '' }}>
                                        Female
                                    </label>
                                    <label class="ms-2 d-inline-block">
                                        <input type="radio" name="gender" value="other"
                                            {{ !empty(auth()->user()->personal_profile) && auth()->user()->personal_profile->gender === 'other' ? 'checked' : '' }}>
                                        Other
                                    </label>
                                    <br>
                                    @error('gender')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="inputAddress" class="form-label">Address:</label>
                                    <input type="text" placeholder="address"
                                        value="{{ auth()->user()->personal_profile->address ?? '' }}"
                                        class="form-control @error('address') is-invalid @enderror" id="inputAddress"
                                        name="address">
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="inputCountry" class="form-label">Country:</label>
                                    <select id="inputCountry" name="country"
                                        class="form-select select_2 @error('country') is-invalid @enderror">
                                        <option selected disabled>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ !empty(auth()->user()->personal_profile->country_id) && auth()->user()->personal_profile->country_id === $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('country')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="inputState" class="form-label">State:</label>
                                    <select id="inputState" name="state"
                                        class="form-select select_2 @error('state') is-invalid @enderror">

                                    </select>
                                    @error('state')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="inputCity" class="form-label">City:</label>
                                    <select id="inputCity" name="city"
                                        class="form-select select_2 @error('city') is-invalid @enderror">


                                    </select>
                                    @error('city')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="inputZip" class="form-label">Zip Code:</label>
                                    <input type="text" value="{{ auth()->user()->personal_profile->zip_code ?? '' }}"
                                        class="form-control @error('zip') is-invalid @enderror" id="inputZip"
                                        name="zip">
                                    @error('zip')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="file_input" class="form-label">Profile Photo:</label>
                                    <input class="form-control @error('photo') is-invalid @enderror" id="file_input"
                                        type="file" name="photo">
                                    <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px;">Image
                                        ratio 150x150px and
                                        maximum image size 300kb.
                                    </p>
                                    @error('photo')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/profile_photo/' . auth()->user()->photo) }}"
                                            id="show_img" alt="" width="100">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if (auth()->user()->hasRole('fundraiser'))
                        <div class="tab-pane fade" id="academic_profile">
                            <form method="POST" action="{{ route('user.profile.academic.update', auth()->user()->id) }}"
                                class="account_content_area_form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <label for="inputcoll" class="form-label">College/University:<span
                                                class="text-danger">*</span></label>
                                        <label class="form-label ms-5">
                                            If not listed, click here <input type="checkbox" id="onlistUniversity">
                                        </label>
                                        <div class="collage_select">
                                            <select id="inputcoll"
                                                class="select_2 @error('university') is-invalid @enderror"
                                                name="university">
                                                <option selected disabled>Select College/University</option>
                                                @foreach ($universities as $university)
                                                    <option value="{{ $university->id }}"
                                                        {{ !empty(auth()->user()->academic_profile->university_id) && auth()->user()->academic_profile->university_id === $university->id ? 'selected' : '' }}>
                                                        {{ $university->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="displayBox">
                                            <input type="text" class="form-control"
                                                placeholder="Enter College/University Name" name="university_name"
                                                disabled>
                                        </div>
                                        @error('university')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label for="inputStudyMajor" class="form-label">Study Major:<span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control  @error('major_study') is-invalid @enderror"
                                            name="major_study" placeholder="Study Major" id="inputStudyMajor"
                                            value="{{ old('major_study', auth()->user()->academic_profile->study ?? '') }}">
                                        @error('major_study')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="inputClassification" class="form-label">Classification:<span
                                                class="text-danger">*</span></label>
                                        <select id="inputClassification"
                                            class="select_2  @error('classification') is-invalid @enderror"
                                            name="classification">
                                            <option selected disabled>Select Classification</option>
                                            @foreach ($classifications as $classification)
                                                <option value="{{ $classification->id }}"
                                                    {{ !empty(auth()->user()->academic_profile->classification_id) && auth()->user()->academic_profile->classification_id === $classification->id ? 'selected' : '' }}>
                                                    {{ $classification->name }}</option>
                                            @endforeach

                                        </select>
                                        @error('classification')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="inputCurrentGPA" class="form-label">Current GPA:</label>
                                        <input type="text" class="form-control  @error('gpa') is-invalid @enderror"
                                            name="gpa" placeholder="GPA" id="inputCurrentGPA"
                                            value="{{ old('gpa', auth()->user()->academic_profile->gpa ?? '') }}">
                                        <label class="pt-1 form-label">
                                            <input class="form-check-input" type="checkbox" name="show_gpa"
                                                {{ !empty(auth()->user()->academic_profile->show_gpa) && auth()->user()->academic_profile->show_gpa != null ? 'checked' : '' }}>
                                            I consent to show GPA on my profile.
                                        </label>
                                        @error('gpa')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="inputDegreeEnrolledIn" class="form-label">Degree
                                            Enrolled: <span class="text-danger">*</span></label>
                                        <select id="inputDegreeEnrolledIn"
                                            class="select_2  @error('degree') is-invalid @enderror" name="degree">
                                            <option selected disabled>Select Degree</option>
                                            @foreach ($degreenEnroleds as $degreenEnroled)
                                                <option value="{{ $degreenEnroled->id }}"
                                                    {{ !empty(auth()->user()->academic_profile->degree_enrolled_id) && auth()->user()->academic_profile->degree_enrolled_id === $degreenEnroled->id ? 'selected' : '' }}>
                                                    {{ $degreenEnroled->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('degree')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-lg-6 mb-3">
                                        <label for="schedule" class="form-label">Class
                                            Schedule:</label>
                                        <input class="form-control  @error('schedule') is-invalid @enderror"
                                            type="file" name="schedule" placeholder="Class Schedule" id="schedule">
                                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px">Maximum
                                            Uploaded image size
                                            300kb.
                                        </p>
                                        <label class="pt-1 form-label">
                                            <input class="form-check-input" name="schedule_show" type="checkbox"
                                                {{ !empty(auth()->user()->academic_profile->show_schedule) && auth()->user()->academic_profile->show_schedule != null ? 'checked' : '' }}>
                                            I consent to show Class Schedule on my profile.
                                        </label>

                                        @error('schedule')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        @if (!empty(auth()->user()->academic_profile->schedule))
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/class_schedule/' . auth()->user()->academic_profile->schedule) }}"
                                                    id="schedule_show_img" alt="" width="100">
                                            </div>
                                        @endif

                                    </div> --}}
                                    {{-- <div class="col-lg-6 mb-3">
                                        <label for="transcript" class="form-label">Transcript:</label>
                                        <input class="form-control  @error('transcript') is-invalid @enderror"
                                            type="file" name="transcript" id="transcript" placeholder="Transcript">
                                        <p style="color: rgba(54, 76, 102, 0.7); font-size: 13px">Maximum
                                            Uploaded image size
                                            300kb.
                                        </p>
                                        <label class="pt-1 form-label">
                                            <input class="form-check-input" type="checkbox" name="transcript_show"
                                                {{ !empty(auth()->user()->academic_profile->show_transcript) && auth()->user()->academic_profile->show_transcript != null ? 'checked' : '' }}>
                                            I consent to show transcript on my profile.
                                        </label>

                                        @error('transcript')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        @if (!empty(auth()->user()->academic_profile->transcript))
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/transcript/' . auth()->user()->academic_profile->transcript) }}"
                                                    id="transcript_show_img" alt="" width="100">
                                            </div>
                                        @endif

                                    </div> --}}
                                    <div class="col-lg-12 mb-3">
                                        <label for="experience" class="form-label">Professional
                                            Experience:</label>
                                        <textarea class="form-control  @error('experience') is-invalid @enderror" row="6" name="experience"
                                            id="experience" placeholder="Professional Experience">{!! auth()->user()->academic_profile->experience ?? '' !!}</textarea>
                                        @error('experience')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                    </div>


                                    <div class="col-12">
                                        <button type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="tab-pane fade" id="social_profile">
                        <form method="POST" action="{{ route('user.profile.social.upload', auth()->user()->id) }}"
                            class="account_content_area_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="linkedin" class="form-label">LinkedIn:</label>
                                    <input type="text" placeholder="Linkedin Url"
                                        value="{{ old('linkedin', auth()->user()->userSocial->linkedin ?? '') }}"
                                        name="linkedin" class="form-control @error('linkedin') is-invalid @enderror"
                                        id="inputlink">
                                    @error('linkedin')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="instagram" class="form-label">Instagram:</label>
                                    <input type="text" placeholder="Instagram Url"
                                        value="{{ old('instagram', auth()->user()->userSocial->instagram ?? '') }}"
                                        name="instagram" class="form-control @error('instagram') is-invalid @enderror"
                                        id="instagram">
                                    @error('instagram')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="facebook" class="form-label">Facebook:</label>
                                    <input type="text" placeholder="Facebook Url"
                                        value="{{ old('facebook', auth()->user()->userSocial->facebook ?? '') }}"
                                        name="facebook" class="form-control @error('facebook') is-invalid @enderror"
                                        id="facebook">
                                    @error('facebook')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="twitter" class="form-label">Twitter/X:</label>
                                    <input type="text" placeholder="Twitter Url"
                                        value="{{ old('twitter', auth()->user()->userSocial->twitter ?? '') }}"
                                        name="twitter" class="form-control @error('twitter') is-invalid @enderror"
                                        id="twitter">
                                    @error('twitter')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="tiktok" class="form-label">Tiktok:</label>
                                    <input type="text" placeholder="Tiktok Url"
                                        value="{{ old('tiktok', auth()->user()->userSocial->tiktok ?? '') }}"
                                        name="tiktok" class="form-control @error('tiktok') is-invalid @enderror"
                                        id="tiktok">
                                    @error('tiktok')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="youtube" class="form-label">YouTube:</label>
                                    <input type="text" placeholder="YouTube Url"
                                        value="{{ old('youtube', auth()->user()->userSocial->youtube ?? '') }}"
                                        name="youtube" class="form-control @error('youtube') is-invalid @enderror"
                                        id="youtube">
                                    @error('youtube')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="snapchat" class="form-label">Snapchat:</label>
                                    <input type="text" placeholder="snapchat Url"
                                        value="{{ old('snapchat', auth()->user()->userSocial->snapchat ?? '') }}"
                                        name="snapchat" class="form-control @error('snapchat') is-invalid @enderror"
                                        id="snapchat">
                                    @error('snapchat')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="pinterest" class="form-label">Pinterest:</label>
                                    <input type="text" placeholder="Pinterest Url"
                                        value="{{ old('pinterest', auth()->user()->userSocial->pinterest ?? '') }}"
                                        name="pinterest" class="form-control @error('pinterest') is-invalid @enderror"
                                        id="pinterest">
                                    @error('pinterest')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="website" class="form-label">Website:</label>
                                    <input type="text" placeholder="Website Url"
                                        value="{{ old('website', auth()->user()->userSocial->website ?? '') }}"
                                        name="website" class="form-control @error('website') is-invalid @enderror"
                                        id="website">
                                    @error('website')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
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
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    @if (auth()->user()->hasRole('fundraiser'))
        <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
        <script>
            //editor
            ClassicEditor.create(document.querySelector('#experience'), {
                    ckfinder: {
                        uploadUrl: "{{ route('user.profile.experience.photo.upload') . '?_token=' . csrf_token() }}",
                    }
                })
                .catch(error => {
                    console.error(error);
                });

            let schedule = document.getElementById("schedule");
            let schedule_show_img = document.getElementById("schedule_show_img");

            schedule.addEventListener("change", function(event) {
                let tmppath = URL.createObjectURL(event.target.files[0]);
                schedule_show_img.src = tmppath;
            });

            let transcript = document.getElementById("transcript");
            let transcript_show_img = document.getElementById("transcript_show_img");

            transcript.addEventListener("change", function(event) {
                let tmppath = URL.createObjectURL(event.target.files[0]);
                transcript_show_img.src = tmppath;
            });

            //university select box
            $(document).ready(function() {
                $("#onlistUniversity").on("click", function() {
                    var dInput = $('.displayBox input');
                    var collage_select_box = $('.collage_select select');
                    if (dInput.attr('disabled')) {
                        dInput.removeAttr('disabled')
                    } else {
                        dInput.attr('disabled', 'disabled')
                    }
                    if (collage_select_box.attr('disabled')) {
                        collage_select_box.removeAttr('disabled')
                    } else {
                        collage_select_box.attr('disabled', 'disabled')
                    }
                    $('.collage_select').toggleClass('d-none');
                    $(".displayBox").toggle(this.checked);
                });
            });
        </script>
    @endif

    <script>
        //image change

        let imgf = document.getElementById("file_input");
        let output = document.getElementById("show_img");

        imgf.addEventListener("change", function(event) {
            let tmppath = URL.createObjectURL(event.target.files[0]);
            output.src = tmppath;
        });



        $(document).ready(function() {
            $('.select_2').select2();
            //tab change
            $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#fundeducationTab a[href="' + activeTab + '"]').tab('show');
            }

            //country state city change
            var inputCountry = $('#inputCountry');
            var inputState = $('#inputState');
            var inputCity = $('#inputCity');

            inputCountry.on('change', function() {

                inputState.removeAttr('disabled');
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.profile.state') }}",
                    data: {
                        country_id: inputCountry.val(),
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        inputState.html(data);
                    }

                });

            });

            inputState.on('change', function() {

                inputCity.removeAttr('disabled');
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.profile.city') }}",
                    data: {
                        state_id: inputState.val(),
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        inputCity.html(data);
                    }

                });

            });

            $(window).on('load', function() {
                inputState.removeAttr('disabled');
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.profile.state') }}",
                    data: {
                        country_id: inputCountry.val(),
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        inputState.html(data);
                    }

                });

                setTimeout(function() {
                    inputCity.removeAttr('disabled');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.profile.city') }}",
                        data: {
                            state_id: inputState.val(),
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'JSON',
                        success: function(data) {
                            inputCity.html(data);
                        }

                    });
                }, 500);

            });

        });
    </script>
@endsection
