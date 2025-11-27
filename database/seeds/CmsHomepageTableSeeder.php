<?php

use App\Models\CmsHomepage;
use Illuminate\Database\Seeder;

class CmsHomepageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'id'             => 1,
                'product_id'     => null,
                'post_id'        =>null,
            ],
        ];

        CmsHomepage::insert($settings);
    }
}
