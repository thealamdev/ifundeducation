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
        Schema::create( 'donates', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'donar_id' )->nullable()->constrained( 'users' );
            $table->foreignId( 'fundraiser_post_id' )->constrained();
            $table->string( 'charge_id' );
            $table->string( 'balance_transaction_id' );
            $table->string( 'donar_name' );
            $table->string( 'donar_email' );
            $table->decimal( 'amount' );
            $table->decimal( 'stripe_fee' );
            $table->decimal( 'platform_fee' );
            $table->decimal( 'net_balance' );
            $table->string( 'currency' );
            $table->string( 'status' )->default( 'succeeded' );
            $table->string( 'display_publicly' )->default( 'yes' );
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
        Schema::dropIfExists( 'donates' );
    }
};