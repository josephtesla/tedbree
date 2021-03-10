<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('company');
            $table->string('location');
            $table->text('description');
            $table->enum('type', \App\Models\Job::JOB_TYPES);
            $table->enum('category', \App\Models\Job::JOB_CATEGORIES);
            $table->enum('work_condition', \App\Models\Job::WORK_CONDITIONS);
            $table->string('salary_range');
            $table->date('deadline');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
