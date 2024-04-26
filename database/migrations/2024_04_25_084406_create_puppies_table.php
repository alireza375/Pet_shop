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
        Schema::create('puppies', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->string('name');
            $table->unsignedBigInteger('breed_id');
            $table->foreign('breed_id')->references('id')->on('breeds')->onDelete('cascade');
            $table->string('gender');
            $table->string('address');
            $table->string('price');
            $table->text('description');
            $table->text('about');
            $table->tinyInteger('status')->comment('active = 1,inactive = 0')->default(INACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puppies');
    }
};
