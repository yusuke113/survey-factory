<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\QreVote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QreVoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('qre_votes')->truncate();
        QreVote::factory(200)->create();
    }
}
