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
        Schema::create('sub__categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_categories_id');
            $table->foreign('service_categories_id')->references('id')->on('service_categories')->onDelete('cascade');
            $table->string('name');
            $table->tinyInteger('status')->comment('active = 1,inactive = 0')->default(ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub__categories');
    }
};
