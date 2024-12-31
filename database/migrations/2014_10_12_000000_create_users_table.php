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
        Schema::create( 'users', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'first_name' );
            $table->string( 'last_name' )->nullable();
            $table->string( 'email' )->unique();
            $table->timestamp( 'email_verified_at' )->nullable();
            $table->string( 'password' )->nullable();
            $table->string( 'photo' )->nullable();
            $table->string( 'provider_id' )->nullable();
            $table->string( 'provider' )->nullable();
            $table->string( 'avatar' )->nullable();
            $table->string( 'stripe_account_id' )->nullable();
            $table->string( 'status' )->default( 1 )->comment( "1=active, 2= deactive" );
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'users' );
    }
};