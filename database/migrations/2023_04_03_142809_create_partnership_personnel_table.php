<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnershipPersonnelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partnership_personnel', function (Blueprint $table) {
            $table->id();
            // $table->id();
            $table->foreignId('partnership_id')->unsigned()->constrained('partnerships')->onDelete('cascade');
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
        Schema::dropIfExists('partnership_personnel');
    }
}
