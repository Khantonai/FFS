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
                'name' => 'Exploration',
            ],
            [
                'name' => 'Topographie',
            ],
            [
                'name' => 'Photographie',
            ],
            [
                'name' => 'Étude géologique',
            ],
            [
                'name' => 'Cartographie',
            ],
            [
                'name' => 'Recherche scientifique',
            ],
            [
                'name' => 'Plongée souterraine',
            ],
            [
                'name' => 'Escalade',
            ],
            [
                'name' => 'Randonnée',
            ],
            [
                'name' => 'Formation en spéléologie',
            ],
            [
                'name' => 'Expéditions',
            ],
            [
                'name' => 'Protection de l\'environnement',
            ],
            [
                'name' => 'Documentation',
            ],
            [
                'name' => 'Archéologie',
            ],
            [
                'name' => 'Enseignement et sensibilisation',
            ],
            [
                'name' => 'Sauvetage',
            ],
            [
                'name' => 'Autre',
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
?>

