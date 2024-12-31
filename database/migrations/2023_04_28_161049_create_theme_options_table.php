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
        Schema::create('theme_options', function (Blueprint $table) {
            $table->id();
            $table->string('header_email')->nullable();
            $table->string('header_phone')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('footer_about_title')->nullable();
            $table->string('footer_about_description')->nullable();
            $table->string('footer_email')->nullable();
            $table->string('footer_phone')->nullable();
            $table->string('footer_web_address')->nullable();
            $table->string('footer_web_address_link')->nullable();
            $table->string('copyright_text')->nullable();
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
        Schema::dropIfExists('theme_options');
    }
};
