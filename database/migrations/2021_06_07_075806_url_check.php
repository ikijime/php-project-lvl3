<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Prophecy\Doubler\ClassPatch\KeywordPatch;

class UrlCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_checks', function (Blueprint $table) {
            $table->id();
            $table->integer('status_code');
            $table->string('h1');
            $table->string('keywords');
            $table->text('description');
            $table->timestamps();
        });
        
        Schema::table('url_checks', function (Blueprint $table) {
            $table->unsignedBigInteger('url_id')->nullable();
        
            $table->foreign('url_id')->references('id')->on('urls');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('url_checks');
    }
}
