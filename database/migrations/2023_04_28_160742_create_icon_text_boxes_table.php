<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icon_text_boxes', function (Blueprint $table) {
            $table->id();
            $table->integer('serial')->default(1);
            $table->string('icon')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('link')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icon_text_boxes');
    }
};
