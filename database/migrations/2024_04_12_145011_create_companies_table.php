<?php

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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('title')->nullable();
            $table->string('site');

            $table->date('age_date')->nullable();
            $table->bigInteger('numbers', unsigned: true)->default(0); // численность, например: 1001-5000 человек

            $table->string('location')->nullable(); // страна

            // это не подходит, т.к. он создаст поле с именем user_id, а мне нужен 'spokesperson'
            // $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            // вот это уже работает
            // $table->foreignId('spokesperson')->nullable()->constrained('users')->nullOnDelete();
            // 2-й вариант
            $table->unsignedBigInteger('spokesperson_id')->nullable();
            $table->foreign('spokesperson_id')->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
