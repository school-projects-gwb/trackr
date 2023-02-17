<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shipment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->foreignId('shipment_id')->constrained('shipments');
            $table->timestamps();
            // Make sure combination of status and shipment ID is unique
            $table->unique(['status', 'shipment_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipment_statuses');
    }
};
