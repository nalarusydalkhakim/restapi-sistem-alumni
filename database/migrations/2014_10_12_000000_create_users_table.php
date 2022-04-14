<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nik')->unique();
            $table->string('nim')->unique();
            $table->string('faculty')->nullable();
            $table->string('departement')->nullable();
            $table->date('entry_year')->nullable();
            $table->date('graduate_year')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('gender')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('social_media')->nullable();
            $table->double('gpa')->nullable();
            $table->string('diploma_number')->nullable();
            $table->string('organization')->nullable();
            $table->string('achievement')->nullable();
            $table->string('photo')->nullable();
            $table->string('identity_card')->nullable();
            $table->string('bachelor_certificate')->nullable();
            $table->boolean('first')->default(true);
            $table->boolean('completed')->default(false);
            $table->boolean('validated')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
