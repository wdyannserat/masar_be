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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //*Common columns for all roles
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('username', 255)->unique()->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->string('phone_number', 255)->unique()->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender',['male','female'])->nullable();
            $table->string('address', 255)->nullable();
            $table->enum('role', ['Manager', 'Admin', 'Parent', 'Facilitator']);
            $table->string('password', 255);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('attachment_id')->nullable();
            $table->foreign('attachment_id')->on('attachments')->references('id');
            //* Facilitator
            $table->date('volunteering_start_date')->nullable();
            $table->date('volunteering_end_date')->nullable();
            $table->string('notes',500)->nullable();
            //*Parent
            $table->integer('number_of_children')->nullable();
            $table->string('parent_full_name',255)->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
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
};
