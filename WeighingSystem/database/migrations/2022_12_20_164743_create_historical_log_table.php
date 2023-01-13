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
        Schema::create('historical_log', function (Blueprint $table) {
            $table->id();
            $table->string('line_name');
            $table->string('machine_name');
            $table->string('shift_name');
            $table->string('sku_name');
            $table->double('weight');
            $table->double('target');
            $table->double('th_H');
            $table->double('th_L');
            $table->string('status');
            // $table->timestamps();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historical_log');
    }
};
