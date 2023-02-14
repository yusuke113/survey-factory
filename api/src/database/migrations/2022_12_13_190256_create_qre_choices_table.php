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
        Schema::create('qre_choices', function (Blueprint $table) {
            $table->id()->comment('アンケート選択肢ID');
            $table->uuid()->unique('idx_questionnaires_uuid')->comment('アンケート選択肢UUID');
            $table->foreignId('questionnaire_id')
                  ->constrained()
                  ->index('idx_qre_choices_questionnaire_id')
                  ->comment('アンケートID');
            $table->string('body', 30)->comment('選択肢内容');
            $table->unsignedTinyInteger('display_order')->comment('選択肢順序');
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
        Schema::dropIfExists('qre_choices');
    }
};
