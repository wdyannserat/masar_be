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
        Schema::create('session_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('rate', ['1', '2', '3', '4', '5'])->default('1');
            $table->foreignId('child_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_session_id')->constrained('program_session')->cascadeOnDelete();
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
        Schema::dropIfExists('session_rates');
    }
};
