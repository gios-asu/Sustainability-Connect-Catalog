<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->text('compensation')->nullable();
            $table->text('responsibilities')->nullable();
            $table->text('learning_outcomes')->nullable();
            $table->text('sustainability_contribution')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('application_overview')->nullable();
            $table->text('implementation_paths')->nullable();
            $table->string('budget_type')->nullable();
            $table->string('budget_amount')->nullable();
            $table->string('program_lead')->nullable();
            $table->string('success_story')->nullable();
            $table->string('library_collection')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}