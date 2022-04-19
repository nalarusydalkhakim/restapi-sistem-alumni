<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracerEntrepreneursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracer_entrepreneurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('business_name')->nullable();
            $table->string('business_address')->nullable();
            $table->string('business_sector')->nullable();
            $table->string('business_phone')->nullable();
            $table->year('establish_year')->nullable();
            $table->enum('capital_source', ['pribadi', 'investasi', 'hibah'])->nullable();
            $table->integer('income')->nullable();
            $table->boolean('business_matches')->nullable();
            $table->boolean('completed')->default(false);
            $table->date('expired_date')->nullable();
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
        Schema::dropIfExists('tracer_entrepreneurs');
    }
}
