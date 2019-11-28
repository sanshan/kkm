<?php

use App\KKM;
use Illuminate\Database\Seeder;

class KKMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(KKM::class, 5000)->create();
    }
}
