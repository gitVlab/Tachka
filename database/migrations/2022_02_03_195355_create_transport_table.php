<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('mark', 50);
            $table->string('model', 50);
            $table->decimal('cost', 12, 2);
            $table->string('transmission', 50);
            $table->integer('age');
            $table->string('engine_type', 50);
            $table->integer('customer_id');
            $table->string('drive_type', 50);
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
        Schema::dropIfExists('transport');
    }
}
