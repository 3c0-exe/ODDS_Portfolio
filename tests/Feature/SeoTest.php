<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.url' => 'https://www.oddsstudio.site']);
    }

    public function test_public_pages_have_distinct_metadata_and_canonical_addresses(): void
    {
        $pages = [
            '/' => "ODDS Studio — Let's Build Something Real.",
            '/about' => 'About ODDS — Our Team & Studio',
            '/our-work' => 'Our Work — ODDS Studio',
            '/faqs' => 'FAQs — Working With ODDS',
        ];

        foreach ($pages as $path => $title) {
            $response = $this->get($path . '?preview=services&utm_source=test');
            $response->assertOk();
            $response->assertSee('<title>' . e($title) . '</title>', false);
            $response->assertSee('<link rel="canonical" href="https://www.oddsstudio.site' . $path . '">', false);
            $response->assertSee('property="og:title" content="' . e($title) . '"', false);
            $response->assertSee('property="og:image" content="https://www.oddsstudio.site/assets/img/odds-social.png"', false);
            $response->assertSee('name="twitter:card" content="summary_large_image"', false);
        }
    }

    public function test_sitemap_contains_only_public_canonical_pages(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $xml = simplexml_load_string($response->getContent());
        $this->assertNotFalse($xml);
        $urls = array_map(fn ($entry) => (string) $entry->loc, iterator_to_array($xml->url, false));
        $this->assertSame([
            'https://www.oddsstudio.site/',
            'https://www.oddsstudio.site/about',
            'https://www.oddsstudio.site/our-work',
            'https://www.oddsstudio.site/faqs',
        ], $urls);
    }

    public function test_robots_advertises_sitemap_and_excludes_admin_paths(): void
    {
        $this->get('/robots.txt')->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Sitemap: https://www.oddsstudio.site/sitemap.xml', false)
            ->assertSee('Disallow: /admin', false);
        $this->assertFileDoesNotExist(public_path('robots.txt'));
    }

    public function test_social_image_exists_with_the_advertised_dimensions(): void
    {
        $file = public_path('assets/img/odds-social.png');
        $this->assertFileExists($file);
        $image = getimagesize($file);
        $this->assertSame(1200, $image[0]);
        $this->assertSame(630, $image[1]);
        $this->assertSame('image/png', $image['mime']);
    }
}
