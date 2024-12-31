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
        Schema::create('fundraiser_approval_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fundraiser_post_id');
            $table->text('comments')->nullable();
            $table->string('status')->nullable();
            $table->integer('admin_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fundraiser_approval_comments');
    }
};
