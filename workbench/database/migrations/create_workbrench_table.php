<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 2048)->nullable();
            $table->string('desc', 2048)->nullable();
            $table->text('content')->nullable();
            $table->json('blocks')->nullable();

            // add fields

            $table->timestamps();
        });

        Schema::create('language_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group')->index();
            $table->string('key');
            $table->json('text');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('language_lines');
        Schema::dropIfExists('pages');
    }
};
