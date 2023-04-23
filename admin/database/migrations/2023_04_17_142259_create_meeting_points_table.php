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
        Schema::create('meeting_points', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("title");
            $table->text("description");
            $table->string("location");
            $table->dateTime("meeting_time", 0);
            $table->double("latitude", 10, 6);
            $table->double("longitude", 10, 6);
            $table->boolean("approved")->default(false);
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_points');
    }
};
