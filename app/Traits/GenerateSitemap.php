<?php
/**
 * User: hefengbao
 * Date: 2019-1-8
 * Time: 16:49
 */

namespace App\Traits;

use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap
{
    public function sitemap()
    {
        SitemapGenerator::create(config('app.url'))->writeToFile('sitemap.xml');
    }
}
