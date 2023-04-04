<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPersonnelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personnel_project', function (Blueprint $table) {
            $table->id();
            // $table->id();
            $table->foreignId('project_id')->unsigned()->constrained('projects')->onDelete('cascade');
            $table->foreignId('personnel_id')->unsigned()->constrained('personnels')->onDelete('cascade');
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
        Schema::dropIfExists('personnel_project');
    }
}
