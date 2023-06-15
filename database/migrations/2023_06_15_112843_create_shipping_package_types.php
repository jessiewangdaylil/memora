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
        Schema::create('shipping_package_types', function (Blueprint $table) {
            $table->id();
            $table->string('title', 15);
            $table->string('color', 10)->unllable();
            $table->string('box'); //A/F=>普通,B/F=>輕薄,AB/F=>安全
            $table->boolean('ribbon')->default(false);
            $table->boolean('decorate')->default(false);

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
        Schema::dropIfExists('shipping_package_types');
    }
};
