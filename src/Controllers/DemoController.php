<?php

namespace Mafftor\LaravelFileManager\Controllers;

class DemoController extends LfmController
{
    public function index()
    {
        return view('laravel-file-manager::demo');
    }
}
