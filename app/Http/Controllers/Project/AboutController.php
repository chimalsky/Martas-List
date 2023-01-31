<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\ResourceMeta;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('project.about-overview');
    }

    public function overview()
    {
        $res = $this->getHtml('https://birdpress.adagia.org/about-project-overview-coordinates');
        $body = $res['body'];
        $styles = $res['styles'];
        return view('project.about-overview', compact('body', 'styles'));
    }

    public function navigation()
    {
        $res = $this->getHtml('https://birdpress.adagia.org/about-navigating-in-the-archives');
        $body = $res['body'];
        $styles = $res['styles'];
        return view('project.about-navigation', compact('body', 'styles'));
    }

    public function documentation()
    {
        return view('project.about-documentation');
    }

    public function sources()
    {
        $res = $this->getHtml('https://birdpress.adagia.org/143-2/');
        $body = $res['body'];
        $styles = $res['styles'];
        return view('project.about-sources', compact('body', 'styles'));
    }

    public function visitors()
    {
        return view('project.about-visitors');
    }

    public function colophon()
    {
        $res = $this->getHtml('https://birdpress.adagia.org/about');
        $body = $res['body'];
        $styles = $res['styles'];
        return view('project.about-colophon', compact('body', 'styles'));
    }

    public function dedication()
    {
        $res = $this->getHtml('https://birdpress.adagia.org/dedication');
        $body = $res['body'];
        $styles = $res['styles'];
        return view('project.about-dedication', compact('body', 'styles'));
    }

    protected function getHtml($url)
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
