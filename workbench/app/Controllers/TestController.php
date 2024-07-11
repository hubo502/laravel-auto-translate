<?php
namespace Workbench\App\Controllers;

use Illuminate\Routing\Controller;

class TestController extends Controller
{

    public function index()
    {
        // $page = Page::create(['title' => 'works', 'blocks' => ['en' => ['description' => 'hello']]]);
        // $page->autoTranslate();
        // dd($page);
        // dd($page->toArray());
        return 'works';
    }
}
