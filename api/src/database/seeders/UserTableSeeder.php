<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        User::factory()->create([
            'name' => 'テストメンバー',
            'email' => 'test@example.com',
        ]);
        User::factory(10)->create();
    }
}
