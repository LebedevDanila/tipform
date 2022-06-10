<?php

namespace App\Controllers;

class Sitemap extends BaseController
{

    public function __construct()
    {
        $this->date = date('c');
    }

    public function index()
    {
        $count_profiles = $this->db->table('instagram_profiles')->countAll();
        $profiles       = '';
        for ($i = 0; $i < ceil($count_profiles / 40000); $i++) {
            $profiles .= "<sitemap>
                <loc>https://instaprofi.ru/sitemaps/profiles-$i.xml</loc>
                <lastmod>$this->date</lastmod>
            </sitemap>";
        }

        $response = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
                <sitemap>
                    <loc>https://instaprofi.ru/sitemaps/pages.xml</loc>
                    <lastmod>$this->date</lastmod>
                </sitemap>
                <sitemap>
                    <loc>https://instaprofi.ru/sitemaps/articles.xml</loc>
                    <lastmod>$this->date</lastmod>
                </sitemap>
                $profiles
        </sitemapindex>";

        return $this->response->setXML($response);
    }

    public function pages()
    {
        $data = [
            '', // home
            'contacts',
            'favorites',
            'blog',
            'blog/novosti',
            'blog/interesnoe',
            'blog/instrukcii',
        ];

        $urls = '';
        foreach($data as $row) {
            $urls .= "<url>
                <loc>https://instaprofi.ru/$row</loc>
                <lastmod>$this->date</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.8</priority>
            </url>";
        }
        
        $response = "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
            $urls
        </urlset>";

        return $this->response->setXML($response);
    }

    public function articles()
    {
        $data = $this->db
            ->table('blog_articles')
            ->select('
                blog_articles.*,
                blog_subjects.name AS subject_name,
                blog_subjects.link AS subject_link,
            ')
            ->where('blog_articles.status', '1')
            ->join('blog_subjects', 'blog_subjects.id = blog_articles.subject_id', 'left')
            ->get()->getResult();

        $urls = '';
        foreach($data as $row) {
            $urls .= "<url>
                <loc>https://instaprofi.ru/blog/$row->subject_link/$row->link</loc>
                <lastmod>$this->date</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.8</priority>
            </url>";
        }

        $response = "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
            $urls
        </urlset>";

        return $this->response->setXML($response);
    }

    public function profiles($id)
    {
        $start = $id === 0 ? 0 : $id * 40000;
        $chunk = $this->db->table('instagram_profiles')->select('username')->get(40000, $start)->getResult();

        $urls = '';
        foreach($chunk as $row) {
            $urls .= "<url>
                <loc>https://instaprofi.ru/profile/$row->username</loc>
                <lastmod>$this->date</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.8</priority>
            </url>";
        }

        $response = "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
            $urls
        </urlset>";

        return $this->response->setXML($response);
    }

}
