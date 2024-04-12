<?php

use App\Models\Company;
use App\Models\User;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            //$table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->text('content')->nullable();

            $table->string('difficulty')->nullable(); // easy, medium, difficult
            $table->bigInteger('views', unsigned: true)->default(0);
            $table->bigInteger('read_time', unsigned: true)->default(0); // minutes
            $table->bigInteger('likes', unsigned: true)->default(0);
            $table->string('status')->nullable(); // draft, published, rejected, on_inspection

            $table->dateTime('published_at')->nullable();

            // tags, устрою связью типа many-to-many

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
