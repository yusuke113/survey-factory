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
        Schema::create('qre_votes', function (Blueprint $table) {
            $table->id()->comment('アンケート投票ID');
            $table->uuid()->unique('idx_questionnaires_uuid')->comment('アンケート投票UUID');
            $table->foreignId('questionnaire_id')
                  ->constrained()
                  ->index('idx_qre_votes_questionnaire_id')
                  ->comment('アンケートID');
            $table->foreignId('qre_choice_id')
                  ->constrained()
                  ->index('idx_qre_votes_qre_choice_id')
                  ->comment('アンケート選択肢ID');
            $table->char('user_token', 36)->comment('投票者トークン');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日時');
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->dateTime('deleted_at')->nullable()->comment('削除日時');

            $table->unique(['qre_choice_id', 'user_token'], 'idx_qre_votes_qre_choice_id_user_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qre_votes');
    }
};
