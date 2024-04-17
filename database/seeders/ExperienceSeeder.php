<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Experience;


class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Exemple de données pour les rapports de spéléologies
        $experiences = [
            [
                'email' => 'john@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'site_name' => 'Caverna de São Tomé',
                'title' => 'Exploration of Caverna de São Tomé',
                'activity_id' => 1,
                'place' => 'Brazil',
                'date' => '2023-07-15',
                'distance' => 500, 
                'priority' => 1,
                'description' => 'This was an exciting exploration journey into the depths of Caverna de São Tomé. We discovered several new chambers and documented unique geological formations.',
                'image' => 'https://placehold.co/400',
                'last_modif' => '',
                'published_at' => '2023-07-20 12:00:00',
            ],
            [
                'email' => 'jane@example.com',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'site_name' => 'Mammoth Cave',
                'title' => 'Survey of Mammoth Cave System',
                'activity_id' => 3,
                'place' => 'United States',
                'date' => '2023-09-20',
                'distance' => 1000, 
                'priority' => 2,
                'description' => 'Our team conducted a comprehensive survey of the Mammoth Cave system, mapping out passages and measuring distances. The data collected will contribute to our understanding of this vast cave network.',
                'image' => 'https://placehold.co/400',
                'last_modif' => 'p1err0t',
                'published_at' => now(),
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::create($experience);
        }
    }
}
?>