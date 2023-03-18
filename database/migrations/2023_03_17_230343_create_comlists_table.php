<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('hours')->nullable();
            $table->foreignId('overtime_id')->nullable();
            $table->string('status')->nullable();
            $table->date('expired_date')->nullable();
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
        Schema::dropIfExists('comlists');
    }
}
