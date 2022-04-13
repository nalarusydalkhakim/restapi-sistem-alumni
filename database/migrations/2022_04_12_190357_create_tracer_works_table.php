<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracerWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracer_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_sector')->nullable();
            $table->string('position')->nullable();
            $table->string('contract_status')->nullable();
            $table->integer('salary')->nullable();
            $table->boolean('job_matches')->nullable();
            $table->date('start_working')->nullable();
            $table->string('get_job_from')->nullable();
            $table->boolean('completed')->default(false);
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
        Schema::dropIfExists('tracer_works');
    }
}
