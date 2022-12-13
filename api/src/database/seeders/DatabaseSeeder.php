<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        $this->call(UserTableSeeder::class);
        $this->call(QuestionnaireTableSeeder::class);
        $this->call(QreVoteTableSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}
