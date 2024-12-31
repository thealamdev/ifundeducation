<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $super_admin = Role::create( ['name' => 'super-admin'] );
        $admin       = Role::create( ['name' => 'admin'] );
        $fundraiser  = Role::create( ['name' => 'fundraiser'] );
        $donor       = Role::create( ['name' => 'donor'] );

        $userSuperAdmin = User::create( [
            'first_name'        => 'Super',
            'last_name'         => 'Admin',
            'email'             => 'super@gmail.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random( 10 ),
        ] );

        $userSuperAdmin->assignRole( $super_admin );

        $userAdmin = User::create( [
            'first_name'        => 'Admin',
            'last_name'         => 'Admin',
            'email'             => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random( 10 ),
        ] );

        $userAdmin->assignRole( $admin );

        $userFundraiser = User::create( [
            'first_name'        => 'Fundraiser',
            'last_name'         => 'User',
            'email'             => 'fundraiser@gmail.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random( 10 ),
        ] );

        $userFundraiser->assignRole( $fundraiser );

        $userDonor = User::create( [
            'first_name'        => 'Donor',
            'last_name'         => 'User',
            'email'             => 'donor@gmail.com',
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random( 10 ),
        ] );

        $userDonor->assignRole( $donor );
    }
}