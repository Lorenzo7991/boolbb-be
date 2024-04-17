<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppartamentsSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appartaments_sponsorships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appartments_id')->constrained()->onDelete('cascade');
            $table->foreignId('sponsorship_id')->constrained()->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('expire_date');
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
        Schema::table('appartaments_sponsorships', function (Blueprint $table) {
            $table->dropForeign(['appartments_id']);
            $table->dropForeign(['sponsorship_id']);
        });

        Schema::dropIfExists('appartaments_sponsorships');
    }
}

