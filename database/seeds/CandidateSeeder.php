<?php

use Illuminate\Database\Seeder;
use KandiData\Candidate;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('candidates')->truncate();

        $candidates = [
            [
                "first_name" => "Jejomar",
                "last_name" => "Binay, Sr.",
                "middle_name" => "Cabauatan",
                "hashtag" => "#binay",
                "twitter_mention" => "@VPJojoBinay",
                "position_id" => 1,
                "period_id" => 1
            ],
            [
                "first_name" => "Miriam",
                "last_name" => "Defensor-Santiago",
                "middle_name" => "Palma",
                "hashtag" => "#miriam2016",
                "twitter_mention" => "@senmiriam",
                "position_id" => 1,
                "period_id" => 1
            ],
            [
                "first_name" => "Rodrigo",
                "last_name" => "Duterte",
                "middle_name" => "Roa",
                "hashtag" => "#du30",
                "twitter_mention" => "@RRD_Davao",
                "position_id" => 1,
                "period_id" => 1
            ],
            [
                "first_name" => "Mary Grace",
                "last_name" => "Llamanzares",
                "middle_name" => "Poe",
                "hashtag" => "#Grace2016",
                "twitter_mention" => "@SenGracePOE",
                "position_id" => 1,
                "period_id" => 1
            ],
            [
                "first_name" => "Manuel",
                "last_name" => "Roxas II",
                "middle_name" => "Araneta",
                "hashtag" => "#roxas",
                "twitter_mention" => "@MARoxas",
                "position_id" => 1,
                "period_id" => 1
            ]
        ];

        foreach ($candidates as $candidate) {
            Candidate::create($candidate);
        }
    }
}
