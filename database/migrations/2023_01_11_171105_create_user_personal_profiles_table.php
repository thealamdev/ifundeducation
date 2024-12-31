<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'user_personal_profiles', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'user_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreignId( 'country_id' )->nullable()->constrained();
            $table->foreignId( 'state_id' )->nullable()->constrained();
            $table->foreignId( 'city_id' )->nullable()->constrained();
            $table->string( 'phone' )->nullable();
            $table->date( 'birthday' )->nullable();
            $table->string( 'address' )->nullable();
            $table->string( 'zip_code' )->nullable();
            $table->string( 'gender' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'user_personal_profiles' );
    }
};