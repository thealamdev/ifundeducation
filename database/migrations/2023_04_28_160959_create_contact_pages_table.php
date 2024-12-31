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
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('sub_title')->nullable();
            $table->string('image')->nullable();
            $table->string('address_icon')->nullable();
            $table->string('address_title')->nullable();
            $table->string('address_text')->nullable();
            $table->string('email_icon')->nullable();
            $table->string('email_title')->nullable();
            $table->string('email_text')->nullable();
            $table->string('phone_icon')->nullable();
            $table->string('phone_title')->nullable();
            $table->string('phone_text')->nullable();
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
        Schema::dropIfExists('contact_pages');
    }
};
