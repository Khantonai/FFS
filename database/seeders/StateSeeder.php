<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\State;


class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Exemple de données pour les rapports de spéléologies
        $states = [
            [
                'name' => 'Submitted',
            ],
            [
                'name' => 'Published',
            ],
            [
                'name' => 'Archived',
            ],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
?>