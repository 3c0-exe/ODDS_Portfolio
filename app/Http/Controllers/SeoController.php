<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $base = rtrim(config('seo.url'), '/');
        $urls = array_map(
            fn (string $name) => $base . route($name, [], false),
            array_keys(config('seo.pages'))
        );

        return response()->view('seo.sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $sitemap = rtrim(config('seo.url'), '/') . '/sitemap.xml';
        $body = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /odds-admin\nDisallow: /api/\nDisallow: /clear-cache\n\nSitemap: {$sitemap}\n";

        return response($body)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
