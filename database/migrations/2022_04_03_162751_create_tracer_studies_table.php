<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracerStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('university_name')->nullable();
            $table->string('university_address')->nullable();
            $table->enum('study_location',['dalam negeri', 'luar negeri'])->nullable();
            $table->string('departement')->nullable();
            $table->year('entry_year')->nullable();
            $table->year('graduate_year')->nullable();
            $table->boolean('study_matches')->nullable();
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
        Schema::dropIfExists('tracer_studies');
    }
}
