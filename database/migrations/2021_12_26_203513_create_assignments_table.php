<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();        
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            // $table->string('course');
            $table->text('description')->nullable();            
            $table->date('due_date');
            $table->time('due_time');
            $table->enum('level', ['Very Easy', 'Easy', 'Medium', 'Hard', 'Very Hard']);
            $table->integer('estimation');
            $table->enum('status', ['DOING', 'DONE'])->default('DOING');
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
        Schema::dropIfExists('assignments');
    }
}
