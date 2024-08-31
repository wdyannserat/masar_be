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
        Schema::create('session_checklists', function (Blueprint $table) {
            $table->id();
            $table->boolean('attendance');
            $table->string('description', 255)->nullable();
            //*Foreign Keys
            $table->foreignId('child_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('session_checklists');
    }
};
