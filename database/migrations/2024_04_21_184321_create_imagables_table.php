<?php

use App\Models\Image;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('imagables', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Image::class)->constrained()->cascadeOnDelete();
            $table->integer('imagable_id');
            $table->string('imagable_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagables');
    }
};