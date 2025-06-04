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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('species');
            $table->boolean('is_predator');
            $table->timestamp('born_at');
            $table->string('image_name')->nullable();
            $table->string('image_name_hash')->nullable();

            // 1 to N relationship with enclosures
            $table->unsignedBigInteger('enclosure_id')->nullable();
            $table->foreign('enclosure_id')->references('id')->on('enclosures');
            $table->timestamps();
        });

        Schema::table('animals', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('animals');
    }
};
