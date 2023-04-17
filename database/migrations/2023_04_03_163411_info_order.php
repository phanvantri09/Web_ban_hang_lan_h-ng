<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InfoOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('info_order', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('id_cart');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('numberphone')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable()->comment('Thông tin nhà cung cấp');
            $table->integer('total')->nullable();
            $table->integer('status')->nullable();
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
        Schema::drop('info_order');
    }
}
