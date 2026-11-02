<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /*
     * Просмотр страницы
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);

        return view('pages.show', [
            'page' => $page,
        ]);
    }
}
