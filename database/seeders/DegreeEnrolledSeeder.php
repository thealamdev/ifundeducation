<?php

namespace Database\Seeders;

use App\Models\DegreeEnrolled;
use Illuminate\Database\Seeder;

class DegreeEnrolledSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DegreeEnrolled::create( [
            'name' => 'Undergraduate',
        ] );
        DegreeEnrolled::create( [
            'name' => 'Graduate',
        ] );
        DegreeEnrolled::create( [
            'name' => 'Doctorate',
        ] );
        DegreeEnrolled::create( [
            'name' => 'Associate',
        ] );
    }
}