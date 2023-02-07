<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id()->comment('アンケートID');
            $table->uuid()->unique('idx_questionnaires_uuid')->comment('アンケートUUID');
            $table->foreignId('user_id')->constrained()->index('idx_questionnaires_user_id')->comment('ユーザーID');
            $table->string('title', 30)->comment('アンケートタイトル');
            $table->string('description', 50)->nullable()->comment('アンケート説明');
            $table->string('thumbnail_url', 2083)->nullable()->comment('サムネイルURL');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->dateTime('deleted_at')->nullable()->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaires');
    }
};
