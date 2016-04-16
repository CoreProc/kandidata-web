<?php

use Illuminate\Database\Seeder;
use KandiData\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = ['President'];

        foreach ($positions as $position) {
            Position::create([
                'name' => $position
            ]);
        }
    }
}
