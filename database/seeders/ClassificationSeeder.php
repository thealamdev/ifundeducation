<?php

namespace Database\Seeders;

use App\Models\Classification as ModelsClassification;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        ModelsClassification::create( [
            'name' => 'Freshman',
        ] );
        ModelsClassification::create( [
            'name' => 'Sophomore',
        ] );
        ModelsClassification::create( [
            'name' => 'Junior',
        ] );
        ModelsClassification::create( [
            'name' => 'Senior',
        ] );
        ModelsClassification::create( [
            'name' => 'Other',
        ] );
    }
}