<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Activity;


class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $activities = [
            [
                'name' => 'Spéléologie',
            ],
            [
                'name' => 'Canyoning',
            ],
            [
                'name' => 'Exploration Sous-marine',
            ]
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
?>

