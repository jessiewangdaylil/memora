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
        Schema::create('temp_phone_codes', function (Blueprint $table) {
            $table->id();
            $table->string("url", 255); //取得的網址
            $table->string("path", 255); //資料位於伺服器的路徑
            $table->json("data"); //取得的資料
//版本控管
            $table->json("create_data")->nullable(); //建立
            $table->json("delete_data")->nullable(); //刪除
            $table->json("update_data")->nullable(); //修改
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
        Schema::dropIfExists('temp_phone_codes');
    }
};