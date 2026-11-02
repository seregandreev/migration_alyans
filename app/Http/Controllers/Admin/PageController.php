<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /*
     * Список страниц
     */
    public function index()
    {
        $pages = Page::orderBy('id', 'desc')
            ->get();

        return view('admin.pages.index', [
            'pages' => $pages,
        ]);
    }


    /*
     * Редактирование
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.edit', [
            'page' => $page,
        ]);
    }


    /*
     * Сохранение изменений
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->update($request->all());

        return redirect()
            ->to(route('admin.pages'));
    }
}
