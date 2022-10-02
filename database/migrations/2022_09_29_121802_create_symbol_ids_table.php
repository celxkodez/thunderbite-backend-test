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
        Schema::create('symbol_ids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_url');
            $table->integer('match_point_3')->default(3);
            $table->integer('match_point_4')->default(4);
            $table->integer('match_point_5')->default(5);
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('symbol_ids');
    }
};
