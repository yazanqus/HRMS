<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('days')->nullable();
            $table->string('hours')->nullable();
            $table->string('reason')->nullable();
            $table->string('lmapprover')->nullable();
            $table->string('lmcomment')->nullable();
            $table->string('hrapprover')->nullable();
            $table->string('hrcomment')->nullable();
            $table->string('exapprover')->nullable();
            $table->string('excomment')->nullable();
            $table->string('path')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->softDeletes();
            $table->foreignId('leavetype_id');
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
        Schema::dropIfExists('leaves');
    }
}
