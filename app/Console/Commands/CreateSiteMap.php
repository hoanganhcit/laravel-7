<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // create new sitemap object
        $sitemap = \App::make("sitemap");

        // add items to the sitemap (url, date, priority, freq)
        $sitemap->add(\URL::to('/'), '2022-09-15T20:10:00+07:00', '1.0', 'daily');
        $sitemap->add(\URL::to('/gioi-thieu'), '2022-09-15T20:10:00+07:00', '1.0', 'daily');
        $sitemap->add(\URL::to('/san-pham'), '2022-09-15T20:10:00+07:00', '1.0', 'daily');
        $sitemap->add(\URL::to('/chinh-sach-dai-ly'), '2022-09-15T20:10:00+07:00', '1.0', 'daily');
        $sitemap->add(\URL::to('/cham-soc-khach-hang'), '2022-09-15T20:10:00+07:00', '1.0', 'daily');
        $sitemap->add(\URL::to('/tin-tuc'), '2022-09-15T20:10:00+07:00', '1.0', 'daily');
        $sitemap->add(\URL::to('/lien-he'), '2022-09-15T20:10:00+07:00', '1.0', 'daily');
        $sitemap->add(\URL::to('/cart'), '2022-09-15T20:10:00+07:00', '1.0', 'daily');
        

        $products = \DB::table('products')->orderBy('created_at', 'desc')->get();

        foreach ($products as $product)
        {
            $sitemap->add(env('APP_URL'). "/san-pham/{$product->slug}", $product->created_at, '0.8', 'daily');
        }

        // get all posts from db
        $posts = \DB::table('posts')->orderBy('created_at', 'desc')->get();

        // add every post to the sitemap
        foreach ($posts as $post)
        {
            $sitemap->add(env('APP_URL'). "/tin-tuc/{$post->slug}", $post->created_at, '0.8', 'daily');
        }

        // get all pages from db
        $pages = \DB::table('pages')->orderBy('created_at', 'desc')->get();

        foreach ($pages as $page)
        {
            $sitemap->add(env('APP_URL'). "/chinh-sach/{$page->slug}", $page->created_at, '0.8', 'daily');
        }

        // generate your sitemap (format, filename)
        $sitemap->store('xml', 'sitemap'); 
    }
}
