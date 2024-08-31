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
        Schema::create('age_types', function (Blueprint $table) {
            $table->id();
            /*
            * L1 : from 2 => 5 or 1 , 3 , 5 , 7
            * L2 : from 6 => 10 or  4 , 6 , 9
             */
            $table->string('age_type')->max(255);
            $table->json('ages')->nullable();
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->string('notes',500)->nullable();
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
        Schema::dropIfExists('age_types');
    }
};
