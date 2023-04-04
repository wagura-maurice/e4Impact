<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipPersonnelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_personnel', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('membership_id')->unsigned()->constrained('memberships')->onDelete('cascade');
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
        Schema::dropIfExists('membership_personnel');
    }
}
