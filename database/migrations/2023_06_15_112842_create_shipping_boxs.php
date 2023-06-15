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
        Schema::create('shipping_boxs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 10);
            $table->string('desc', 100)->nullable();
            $table->foreignId('vender_id')->constrained('venders')->unllable();
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
        Schema::create('shipping_boxs', function (Blueprint $table) {
            $table->dropForeign(['vender_id']);
        });

        Schema::dropIfExists('shipping_boxs');
    }
};
