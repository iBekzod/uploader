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
        Schema::connection('uploader')->create('uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('relation_id')->index()->default(0);
            $table->string('relation_type')->default('file');
            $table->string('name');
            $table->string('type');
            $table->string('path');
            $table->string('size');
            $table->string('extension');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('uploader')->dropIfExists('uploads');
    }
};
