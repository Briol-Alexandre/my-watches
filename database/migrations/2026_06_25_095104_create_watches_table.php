<?php

use App\Enums\MovementEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watches', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('picture')->nullable();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->integer('price');
            $table->enum('movement', MovementEnum::values());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watches');
    }
};
