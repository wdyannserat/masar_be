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
        Schema::create('group_session', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['Closed','Opened'])->default('Opened');
            $table->string('description', 255)->nullable();
            $table->unsignedBigInteger('program_session_id');
            $table->foreign('program_session_id')->references('id')->on('program_session')->onDelete('cascade');
            $table->foreignId('group_schedule_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('group_session');
    }
};
