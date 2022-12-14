<?php

return [
    'unauthenticated' => [
        'message' => '認証に失敗しました。',
    ],
    'invalid_argument' => [
        'message' => '不正な引数です。',
    ],
    'not_found' => [
        'message' => ':attributeが存在しません。',
        'attributes' => [
            'user' => 'ユーザー',
            'page' => 'ページ',
            'questionnaire' => 'アンケート',
            'qreChoice' => '選択肢',
        ],
    ],
    'duplicate_qre_vote' => [
        'message' => '既に投票済みです。',
    ],
];
