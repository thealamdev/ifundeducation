<?php

namespace App\Http\Controllers;

use App\Models\AcademicProfile;
use App\Models\City;
use App\Models\Classification;
use App\Models\Country;
use App\Models\DegreeEnrolled;
use App\Models\State;
use App\Models\University;
use App\Models\User;
use App\Models\UserPersonalProfile;
use App\Models\UserSocialProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserProfileController extends Controller {

    /**
     * Edit profile form.
     */
    public function edit() {
        $countries       = Country::all();
        $universities    = University::select('id', 'name')->get();
        $classifications = Classification::all();
        $degreenEnroleds = DegreeEnrolled::all();
        return view('frontend.dashboard.profile', compact('countries', 'universities', 'classifications', 'degreenEnroleds'));
    }

    /**
     * User personal profile update.
     */

    public function personalProfile(Request $request, $id) {

        $user  = User::find(auth()->user()->id);
        $image = $request->file('photo');

        $request->validate([
            "fname"    => 'required',
            "lname"    => 'nullable',
            "phone"    => 'required',
            "birthday" => 'required',
            "gender"   => 'required',
            "address"  => 'nullable',
            "country"  => 'nullable',
            "state"    => 'nullable',
            "city"     => 'nullable',
            "zip"      => 'nullable',
            "photo"    => 'nullable|image|mimes:jpg,png|max:300',
        ]);

        if ($image) {
            if (file_exists(public_path('storage/profile_photo/' . $user->photo))) {
                Storage::delete('profile_photo/' . $user->photo);
            }
            $image_name = Str::uuid() . '.' . $image->extension();

            $upload = Image::make($image)->resize(150, 150)->save(public_path('storage/profile_photo/' . $image_name));
        } else {
            $image_name = $user->photo;
        }

        $user->update([
            "first_name" => $request->fname,
            "last_name"  => $request->lname,
            "photo"      => $image_name,
        ]);

        $result = UserPersonalProfile::updateOrCreate([
            'user_id' => auth()->user()->id,
        ], [
            'user_id'    => auth()->user()->id,
            'phone'      => $request->phone,
            'birthday'   => $request->birthday,
            'gender'     => $request->gender,
            'address'    => $request->address,
            'country_id' => $request->country,
            'state_id'   => $request->state,
            'city_id'    => $request->city,
            'zip_code'   => $request->zip,
        ]);

        if ($result) {
            return back()->with('success', 'Personal Profile Updated!');
        } else {
            return back()->with('error', 'Something wrong, Personal Profile not updated!');
        }

    }

    /**
     * state selected
     */

    public function state(Request $request) {
        $states = State::where('country_id', $request->country_id)->get();

        $state_option = ['<option selected disabled>Select State</option>'];

        foreach ($states as $state) {
            $state_option[] = '<option value="' . $state->id . '"' . (!empty(auth()->user()->personal_profile->state->id) && auth()->user()->personal_profile->state->id === $state->id ? 'selected' : '') . '>' . $state->name . '</option>';

        }

        return response()->json($state_option);

    }

    /**
     * City selected
     */
    public function city(Request $request) {
        $cities = City::where('state_id', $request->state_id)->get();

        $city_option = ['<option selected disabled>Select City</option>'];
        foreach ($cities as $city) {
            $city_option[] = '<option value="' . $city->id . '"' . (!empty(auth()->user()->personal_profile->city->id) && auth()->user()->personal_profile->city->id === $city->id ? 'selected' : '') . '>' . $city->name . '</option>';

        }
        return response()->json($city_option);
    }

    /**
     * academicProfile Profile Update .
     */
    public function academicProfile(Request $request, $id) {
        $user       = User::find(auth()->user()->id);
        $schedule   = $request->file('schedule');
        $transcript = $request->file('transcript');

        if (!$request->university_name) {
            $request->validate([
                'university' => 'required',
            ], [
                'university.required' => 'Select University Name!',
            ]);

        }

        $request->validate([
            'major_study'    => 'required',
            'classification' => 'required',
            'degree'         => 'required',
            'schedule'       => 'nullable|max:300|mimes:png,jpg,webp,jpeg',
            'transcript'     => 'nullable|max:300|mimes:png,jpg,webp,jpeg',
        ]);

        if ($schedule) {
            if (file_exists(public_path('storage/class_schedule/' . $user->academic_profile->schedule))) {
                Storage::delete('class_schedule/' . $user->academic_profile->schedule);
            }
            $schedule_name = Str::uuid() . '.' . $schedule->extension();
            Storage::putFileAs('class_schedule', $schedule, $schedule_name);

        } else {
            $schedule_name = $user->academic_profile->schedule ?? null;
        }
        if ($transcript) {
            if (file_exists(public_path('storage/transcript/' . $user->academic_profile->transcript))) {
                Storage::delete('transcript/' . $user->academic_profile->transcript);
            }
            $transcript_name = Str::uuid() . '.' . $transcript->extension();
            Storage::putFileAs('transcript', $transcript, $transcript_name);

        } else {
            $transcript_name = $user->academic_profile->transcript ?? null;
        }

        if ($request->university_name) {
            $checkexist = University::where('name', $request->university_name)->first();
            if ($checkexist) {
                return back()->with('error', 'College/University exists, Select from this list!');
            }
            $university = University::create([
                'name' => $request->university_name,
            ]);
        }

        $result = AcademicProfile::updateOrCreate([
            'user_id' => auth()->user()->id,
        ], [
            'user_id'            => auth()->user()->id,
            'university_id'      => $request->university ?? $university->id,
            'study'              => $request->major_study,
            'degree_enrolled_id' => $request->degree,
            'classification_id'  => $request->classification,
            'gpa'                => $request->gpa,
            'show_gpa'           => $request->show_gpa === 'on' ? true : false,
            'schedule'           => $schedule_name,
            'show_schedule'      => $request->schedule_show === 'on' ? true : false,
            'transcript'         => $transcript_name,
            'show_transcript'    => $request->transcript_show === 'on' ? true : false,
            'experience'         => $request->experience,
        ]);

        if ($result) {
            return back()->with('success', 'Academic Profile updated!');
        } else {
            return back()->with('error', 'Something wrong, Academic Profile not updated!');
        }
    }

    //ck editor image upload
    public function experiencePhoto(Request $request) {
        if ($request->hasFile('upload')) {
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName  = Str::ulid() . '.' . $extension;

            $request->file('upload')->storeAs('experience', $fileName);

            $url = asset('storage/experience/' . $fileName);

            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    //Social Profile update
    public function socialProfile(Request $request) {

        $request->validate([
            'linkedin'  => 'nullable|url',
            'instagram' => 'nullable|url',
            'facebook'  => 'nullable|url',
            'twitter'   => 'nullable|url',
            'tiktok'    => 'nullable|url',
            'youtube'   => 'nullable|url',
            'snapchat'  => 'nullable|url',
            'pinterest' => 'nullable|url',
            'website'   => 'nullable|url',
        ]);

        $result = UserSocialProfile::updateOrCreate([
            'user_id' => auth()->user()->id,
        ], [
            'linkedin'  => $request->linkedin,
            'instagram' => $request->instagram,
            'facebook'  => $request->facebook,
            'twitter'   => $request->twitter,
            'tiktok'    => $request->tiktok,
            'youtube'   => $request->youtube,
            'snapchat'  => $request->snapchat,
            'pinterest' => $request->pinterest,
            'website'   => $request->website,
        ]);

        if ($result) {
            return back()->with('success', 'Social Profile updated!');
        } else {
            return back()->with('error', 'Something wrong, Social Profile not updated!');
        }
    }

}