<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function welcome()
    {
        $page = Page::findOrFail(1); // Welcome Page

        return view('page', compact('page'));
    }

    public function consultation()
    {
        $page = Page::findOrFail(2); // Welcome Page

        return view('page', compact('page'));
    }
}
