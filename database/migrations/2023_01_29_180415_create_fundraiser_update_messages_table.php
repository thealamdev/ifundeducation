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
        Schema::create( 'fundraiser_update_messages', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'user_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreignId( 'fundraiser_post_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->text( 'message' );
            $table->string( 'message_type' );
            $table->boolean( 'status' )->default( true );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'fundraiser_update_messages' );
    }
};