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
        Schema::create('facilitator_trip', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_trip');
            $table->enum('type', ['OneWay', 'Return']); //  ذهاب و إياب
            $table->string('reason_of_switch')->nullable();
            //*Foreign Keys
            $table->foreignId('expected_facilitator_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('actual_facilitator_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('facilitator_trip');
    }
};
