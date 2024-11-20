<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('equipment_id');
            $table->date('rental_date');
            $table->date('return_date');
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('ongoing');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('equipment_id')->references('id')->on('equipment');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rentals');
    }
};
