<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('tags')->truncate();

        $tagList = [
            ['name' => '一般常識'],
            ['name' => 'アニメ'],
            ['name' => 'マンガ'],
            ['name' => 'ゲーム'],
            ['name' => 'ボカロ'],
            ['name' => 'Youtube'],
            ['name' => '学校'],
            ['name' => 'モデル'],
            ['name' => '芸能'],
            ['name' => 'ポケモン'],
            ['name' => 'コスメ'],
            ['name' => '美容'],
            ['name' => 'グルメ'],
            ['name' => 'ファッション'],
            ['name' => 'アイドル'],
            ['name' => 'kpop'],
            ['name' => '動物'],
            ['name' => '猫'],
            ['name' => '犬'],
            ['name' => '政治'],
            ['name' => 'ニュース'],
        ];

        Tag::factory()->createMany($tagList);
    }
}
