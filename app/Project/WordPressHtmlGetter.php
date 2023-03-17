<?php

namespace App\Project;

use GuzzleHttp\Client;

class WordPressHtmlGetter
{
    public static function execute($url)
    {
        $client = new Client();
        $res = $client->request('GET', $url);
        $html = $res->getBody()->getContents();
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $body = $xpath->query("//div[contains(@class, 'entry-content')]");
        $styles = $xpath->query("//style[starts-with(@id, 'wp-block')]");
        return compact('body', 'styles');
    }
}
