<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Essay;
use App\Models\CompetencyFeedback;
use App\Models\Intervention;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)
            ->has(
                Essay::factory(3)
                    ->has(CompetencyFeedback::factory(5))
                    ->has(Intervention::factory(2))
            )
            ->create();
    }
}
