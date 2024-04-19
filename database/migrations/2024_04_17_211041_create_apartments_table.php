<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('address');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('title', 30)->unique();
            $table->string('slug', 40)->unique();
            $table->text('description')->nullable();
            $table->tinyInteger('rooms');
            $table->tinyInteger('beds');
            $table->tinyInteger('bathrooms');
            $table->smallInteger('square_meters');
            $table->string('image');
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Elimina la cartella apartment_images da storage
        Storage::deleteDirectory('apartment_images');
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropForeignIdFor(User::class);
        });
        Schema::dropIfExists('apartments');
    }
};
