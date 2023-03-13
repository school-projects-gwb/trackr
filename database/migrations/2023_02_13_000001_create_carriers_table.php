<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('carriers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('shipping_cost', $precision = 4, $scale = 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carriers');
    }
};
