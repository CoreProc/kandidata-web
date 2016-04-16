<?php

use Illuminate\Database\Seeder;
use KandiData\Candidate;
use KandiData\Period;
use KandiData\Position;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pos = Position::first();
        $per = Period::first();
        
        $candidates = [
            [
                "first_name" => "Jejomar",
                "last_name" => "Binay, Sr.",
                "middle_name" => "Cabauatan",
                "hashtag" => "#binay",
                "twitter_mention" => "@VPJojoBinay",
                "position_id" => $pos->id,
                "period_id" => $per->id
            ],
            [
                "first_name" => "Miriam",
                "last_name" => "Defensor-Santiago",
                "middle_name" => "Palma",
                "hashtag" => "#miriam2016",
                "twitter_mention" => "@senmiriam",
                "position_id" => $pos->id,
                "period_id" => $per->id
            ],
            [
                "first_name" => "Rodrigo",
                "last_name" => "Duterte",
                "middle_name" => "Roa",
                "hashtag" => "#du30",
                "twitter_mention" => "@RRD_Davao",
                "position_id" => $pos->id,
                "period_id" => $per->id
            ],
            [
                "first_name" => "Mary Grace",
                "last_name" => "Llamanzares",
                "middle_name" => "Poe",
                "hashtag" => "#Grace2016",
                "twitter_mention" => "@SenGracePOE",
                "position_id" => $pos->id,
                "period_id" => $per->id
            ],
            [
                "first_name" => "Manuel",
                "last_name" => "Roxas II",
                "middle_name" => "Araneta",
                "hashtag" => "#roxas",
                "twitter_mention" => "@MARoxas",
                "position_id" => $pos->id,
                "period_id" => $per->id
            ]
        ];

        foreach ($candidates as $candidate) {
            Candidate::create($candidate);
        }
    }
}
