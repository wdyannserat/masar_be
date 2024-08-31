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
        //*for schedule group when to come to the center
        Schema::create('group_schedules', function (Blueprint $table) {
            $table->id();
            $table->time('arrival_time');
            $table->time('departure_time');
            $table->enum('day_number',[1,2,3,4,5,6,7]);
            $table->date('date');
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('group_schedules');
    }
};
