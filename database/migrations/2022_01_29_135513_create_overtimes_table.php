<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->time('start_hour')->nullable();
            $table->time('end_hour')->nullable();
            $table->string('hours')->nullable();
            $table->string('reason')->nullable();
            $table->string('lmapprover')->nullable();
            $table->string('lmcomment')->nullable();
            $table->string('hrapprover')->nullable();
            $table->string('hrcomment')->nullable();
            $table->string('exapprover')->nullable();
            $table->string('excomment')->nullable();
            $table->string('path')->nullable();
            $table->string('value')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->softDeletes();
            // $table->foreignId('overtimetype_id');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('overtimes');
    }
}
