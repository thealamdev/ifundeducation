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
        Schema::create( 'user_social_profiles', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'user_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->string( 'instagram' )->nullable();
            $table->string( 'facebook' )->nullable();
            $table->string( 'linkedin' )->nullable();
            $table->string( 'twitter' )->nullable();
            $table->string( 'youtube' )->nullable();
            $table->string( 'tiktok' )->nullable();
            $table->string( 'snapchat' )->nullable();
            $table->string( 'pinterest' )->nullable();
            $table->string( 'website' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'user_social_profiles' );
    }
};