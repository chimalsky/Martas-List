<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\ResourceMeta;
use Illuminate\Http\Request;
use App\Project\WordPressHtmlGetter;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('project.about-overview');
    }

    public function overview()
    {
        $res = WordPressHtmlGetter::execute('https://birdpress.adagia.org/about-project-overview-coordinates');
        $body = $res['body'];
        $styles = $res['styles'];
        return view('project.about-overview', compact('body', 'styles'));
    }

    public function navigation()
    {
        $res = WordPressHtmlGetter::execute('https://birdpress.adagia.org/about-navigating-in-the-archives');
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
        $res = WordPressHtmlGetter::execute('https://birdpress.adagia.org/143-2/');
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
        $res = WordPressHtmlGetter::execute('https://birdpress.adagia.org/about');
        $body = $res['body'];
        $styles = $res['styles'];
        return view('project.about-colophon', compact('body', 'styles'));
    }

    public function dedication()
    {
        $res = WordPressHtmlGetter::execute('https://birdpress.adagia.org/dedication');
        $body = $res['body'];
        $styles = $res['styles'];
        return view('project.about-dedication', compact('body', 'styles'));
    }
}
