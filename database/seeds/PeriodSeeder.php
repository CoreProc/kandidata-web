<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use KandiData\Period;

class PeriodSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Period::create([
            'name'          => 'Philippine Election 2016',
            'election_date' => Carbon::create(2016, 5, 9)
        ]);
    }
}
