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
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->double('points');
            $table->boolean('is_timed')->default(false);
            $table->integer('duration_in_days')->nullable();
            $table->float('duration_in_hours')->nullable();
            $table->enum('status',['Active','InActive'])->default('Active');
            //*Foreign Key
            $table->foreignId('mission_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('attachment_id')->nullable();
            $table->foreign('attachment_id')->references('id')->on('attachments');
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
        Schema::dropIfExists('challenges');
    }
};