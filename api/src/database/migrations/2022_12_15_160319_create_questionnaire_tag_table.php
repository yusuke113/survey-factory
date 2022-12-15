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
        Schema::create('questionnaire_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->comment('タグID')->onDelete('cascade');
            $table->foreignId('questionnaire_id')->constrained()->comment('アンケートID')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_tag');
    }
};
