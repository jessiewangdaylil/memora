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
        Schema::create('user_advances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); //使用者id
            $table->foreignId('country_id')->constrained('countries'); //居住國家
            $table->foreignId('city_id')->constrained('cities'); //居住城市
            $table->foreignId('town_id')->constrained('towns'); //居住鄉政區
            $table->foreignId('road_id')->constrained('roads'); //居住道路
            $table->foreignId('phone_code_id')->constrained('phone_codes'); //手機國際碼
            $table->foreignId('local_phone_code_id')->constrained('local_phone_codes'); //手機國際碼
            $table->foreignId('auth_level_id')->constrained('auth_levels'); //會員認證階段
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
        Schema::table('user_advances', function (Blueprint $table) {
            $table->dropForeign(['auth_level_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['country_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['town_id']);
            $table->dropForeign(['road_id']);
            $table->dropForeign(['phone_code_id']);
            $table->dropForeign(['local_phone_code_id']);
        });
        Schema::dropIfExists('user_advances');
    }
};
