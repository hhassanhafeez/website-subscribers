<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Seeder;

class WebsiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Website::create([
            'name' => 'Google',
            'description' => 'Founded year 1998'
        ]);

        Website::create([
            'name' => 'Bing',
            'description' => 'Founded year  2009'
        ]);
    }
}
