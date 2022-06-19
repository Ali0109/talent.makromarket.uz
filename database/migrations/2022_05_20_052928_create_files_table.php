<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->default('App\Models\Talent');
            $table->unsignedBigInteger('model_id');
            $table->unsignedInteger('size');
            $table->string('src');
            $table->string('mime_type');
            $table->string('name');
            $table->string('full_name');
            $table->string('extension');
            $table->string('disk')->default('public');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
