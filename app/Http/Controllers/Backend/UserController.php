<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;

class UserController extends Controller {
    //

    public function index() {
        $users = User::with('roles')->orderBy('id', 'desc')->paginate(25);
        return view('backend.user.index', compact('users'));
    }

    public function userBlock($id) {
        $user = User::findOrFail($id);
        $user->update([
            'status' => 2,
        ]);
        return back()->with('success', 'User Successfuly Deactivate!');
    }
    public function userActive($id) {
        $user = User::findOrFail($id);
        $user->update([
            'status' => 1,
        ]);
        return back()->with('success', 'User Successfuly Active!');
    }

    public function create() {
        return view('backend.user.create');
    }
    public function store(Request $request) {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password'   => ['required', 'confirmed', Password::defaults()],
            'status'     => ['required'],
        ]);

        $user = User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'status'            => $request->status,
            'email_verified_at' => now(),
        ]);

        $user->assignRole('admin');

        return back()->with('success', 'Admin User Created!');
    }

    public function edit(User $user) {
        if ($user->id != Auth::id()) {
            abort(401);
        }
        return view('backend.user.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $image = $request->file('photo');

        if ($request->password) {
            $request->validate([
                "photo"      => 'nullable|mimes:jpg,jpeg,png,JPG|max:300',
                'first_name' => ['required', 'string', 'max:255'],
                'last_name'  => ['required', 'string', 'max:255'],
                'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'password'   => ['required', 'confirmed', Password::defaults()],
            ]);

            $user->update([
                "password" => Hash::make($request->password),
            ]);
        } else {
            $request->validate([
                "photo"      => 'nullable|mimes:jpg,jpeg,png,JPG|max:300',
                'first_name' => ['required', 'string', 'max:255'],
                'last_name'  => ['required', 'string', 'max:255'],
                'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            ]);
        }

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
            "first_name" => $request->first_name,
            "last_name"  => $request->last_name,
            "email"      => $request->email,
            "photo"      => $image_name,
        ]);

        return redirect()->route('dashboard.user.allusers')->with('success', 'Profile Update Successfull!');
    }
}
