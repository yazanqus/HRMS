<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->date('start_hour')->nullable();
            $table->string('end_hour')->unique()->nullable();
            $table->string('sign')->nullable();
            $table->string('remarks')->nullable();
            $table->string('leave_overtime_id')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->date('status')->nullable();
            $table->foreignId('leave_id');
            $table->foreignId('overtime_id');
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
        Schema::dropIfExists('attendances');
    }
}
