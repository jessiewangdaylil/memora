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
        Schema::create('roads', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //路名
            $table->integer('level')->default(3); //階層(0國家 1城市 2鄉政區 3路名)
            $table->foreignId('town_id')->constrained('towns'); //所屬鄉政
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
        Schema::table('roads', function (Blueprint $table) {
            $table->dropForeign(['town_id']);
        });
        Schema::dropIfExists('roads');
    }
};