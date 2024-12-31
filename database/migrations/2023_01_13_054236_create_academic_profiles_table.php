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
        Schema::create( 'academic_profiles', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'user_id' )->constrained()->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreignId( 'university_id' )->constrained();
            $table->string( 'study' )->nullable();
            $table->foreignId( 'degree_enrolled_id' )->constrained();
            $table->foreignId( 'classification_id' )->constrained();
            $table->string( 'gpa' )->nullable();
            $table->boolean( 'show_gpa' )->nullable();
            $table->string( 'schedule' )->nullable();
            $table->string( 'show_schedule' )->nullable();
            $table->string( 'transcript' )->nullable();
            $table->string( 'show_transcript' )->nullable();
            $table->longText( 'experience' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'academic_profiles' );
    }
};