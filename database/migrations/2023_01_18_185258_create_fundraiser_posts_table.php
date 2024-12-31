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
        Schema::create('fundraiser_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fundraiser_category_id');
            $table->bigInteger('user_id');
            $table->string('title');
            $table->string('slug');
            $table->text('shot_description');
            $table->decimal('goal');
            $table->date('end_date');
            $table->longText('story')->nullable();
            $table->string('image')->nullable();
            $table->boolean('agree');
            $table->string('status')->default("running");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fundraiser_posts');
    }
};