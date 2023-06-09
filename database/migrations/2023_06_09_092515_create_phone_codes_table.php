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
        Schema::create('phone_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_code')->index()->nullable(); //國碼
            $table->foreign('country_code')->references('code')->on('countries');
            $table->string('code', 20); //國際電話碼
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phone_codes', function (Blueprint $table) {
            $table->dropForeign(['country_code']);
        });

        Schema::dropIfExists('phone_codes');
    }
};