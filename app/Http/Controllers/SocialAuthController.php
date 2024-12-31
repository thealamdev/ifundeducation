<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller {
    public function googleRedirect() {
        return Socialite::driver( 'google' )->redirect();
    }

    public function googleCallback() {

        $googleUser = Socialite::driver( 'google' )->stateless()->user();

        $user = User::updateOrCreate( [
            'provider_id' => $googleUser->getId(),
        ], [
            'first_name'        => $googleUser->getName(),
            'email'             => $googleUser->getEmail(),
            'avatar'            => $googleUser->getAvatar(),
            'provider_id'       => $googleUser->getId(),
            'provider'          => 'google',
            'email_verified_at' => Carbon::now(),
        ] );

        Auth::login( $user );

        return redirect()->route( 'make.role' );

    }
}