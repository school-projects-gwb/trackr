<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shipment_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer("rating");
            $table->string('comment');
            $table
                ->foreignId('shipment_id')
                ->constrained('shipments')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipment_reviews');
    }
};
