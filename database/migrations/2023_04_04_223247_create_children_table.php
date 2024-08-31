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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('username', 255);
            $table->string('password', 255);
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->boolean('is_active')->default(true);
            $table->string('school_name', 255);
            $table->double('points')->default(0.0);
            $table->string('notes', 500)->nullable();
            //*ForeignKeys
            $table->foreignId('parent_id')->constrained('users')->cascadeOnDelete();

            $table->unsignedBigInteger('attachment_id')->nullable();
            $table->foreign('attachment_id')->on('attachments')->references('id');

            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id')->on('positions')->references('id');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->foreign('trip_id')->on('trips')->references('id');
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
        Schema::dropIfExists('children');
    }
};
