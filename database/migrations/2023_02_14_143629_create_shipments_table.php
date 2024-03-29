<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->double('weight');
            $table->foreignId('address_id')->constrained('addresses');
            $table->foreignId('carrier_id')->unsigned()->nullable()->constrained('carriers');
            $table->foreignId('pickup_id')->unsigned()->nullable()->constrained('pickups');
            $table->foreignId('webstore_id')->constrained('webstores');
            $table->timestamps();
            // Full text search
            $table->text('tracking_number')->nullable()->fulltext();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};
