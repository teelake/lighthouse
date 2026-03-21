<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Event;
use App\Models\Media;
use App\Models\Ministry;
use App\Models\SmallGroup;
use App\Models\Job;

/**
 * Sitemap for search engine crawlability.
 */
class SitemapController extends Controller
{
    public function index()
    {
        header('Content-Type: application/xml; charset=utf-8');

        $base = rtrim(BASE_URL ?? '', '/');
        $static = [
            '',
            'about',
            'leadership',
            'services',
            'events',
            'media',
            'membership',
            'ministries',
            'small-groups',
            'giving',
            'contact',
            'faq',
            'im-new',
            'prayer',
            'testimonies',
            'jobs',
        ];

        $urls = [];
        $now = date('c');

        foreach ($static as $path) {
            $loc = $base . ($path ? '/' . $path : '');
            $urls[] = ['loc' => $loc, 'priority' => $path === '' ? '1.0' : '0.8', 'changefreq' => $path === '' ? 'weekly' : 'monthly'];
        }

        foreach ((new Event())->findAll(['is_published' => 1], 'event_date DESC') as $e) {
            if (!empty($e['slug'])) {
                $urls[] = ['loc' => $base . '/events/' . $e['slug'], 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => ($e['updated_at'] ?? $e['created_at'] ?? null)];
            }
        }
        foreach ((new Media())->findAll(['is_published' => 1], 'published_at DESC') as $m) {
            if (!empty($m['slug'])) {
                $urls[] = ['loc' => $base . '/media/' . $m['slug'], 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => ($m['updated_at'] ?? $m['created_at'] ?? null)];
            }
        }
        foreach ((new Ministry())->findAll(['is_published' => 1]) as $m) {
            if (!empty($m['slug'])) {
                $urls[] = ['loc' => $base . '/ministries/' . $m['slug'], 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => ($m['updated_at'] ?? $m['created_at'] ?? null)];
            }
        }
        foreach ((new SmallGroup())->findAll(['is_published' => 1]) as $g) {
            if (!empty($g['slug'])) {
                $urls[] = ['loc' => $base . '/small-groups/' . $g['slug'], 'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => ($g['updated_at'] ?? $g['created_at'] ?? null)];
            }
        }
        foreach ((new Job())->findAll(['is_published' => 1]) as $j) {
            if (!empty($j['slug'])) {
                $urls[] = ['loc' => $base . '/jobs/' . $j['slug'], 'priority' => '0.6', 'changefreq' => 'weekly', 'lastmod' => ($j['updated_at'] ?? $j['created_at'] ?? null)];
            }
        }

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            echo '  <url>' . "\n";
            echo '    <loc>' . htmlspecialchars($u['loc']) . '</loc>' . "\n";
            echo '    <changefreq>' . htmlspecialchars($u['changefreq']) . '</changefreq>' . "\n";
            echo '    <priority>' . $u['priority'] . '</priority>' . "\n";
            if (!empty($u['lastmod'])) {
                echo '    <lastmod>' . date('c', strtotime($u['lastmod'])) . '</lastmod>' . "\n";
            }
            echo '  </url>' . "\n";
        }
        echo '</urlset>';
    }

    public function robots()
    {
        header('Content-Type: text/plain; charset=utf-8');
        $base = rtrim(BASE_URL ?? '', '/');
        echo "User-agent: *\n";
        echo "Allow: /\n\n";
        echo "Disallow: /admin\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /register\n";
        echo "Disallow: /giving/success\n\n";
        echo "Sitemap: {$base}/sitemap.xml\n";
    }
}
