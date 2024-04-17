<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Apartment;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Apartment::class)->constrained()->cascadeOnDelete();
            $table->string('subject', 50);
            $table->text('text');
            $table->string('name', 30);
            $table->string('last_name', 30);
            $table->string('email', 50)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeignIdFor(Apartment::class);
        });
        Schema::dropIfExists('messages');
    }
};
