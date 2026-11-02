<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')
            ->get();
        return view('admin.news.index', [
            'news' => $news,
        ]);
    }


    public function create()
    {
        return view('admin.news.create');
    }


    public function store(Request $request)
    {
        $news = News::create($request->all());

        return redirect()
            ->to(route('news.index'))
            ->with('success', 'Изменения успешно добавлены');
    }


    public function edit($id)
    {
        $news = News::findOrFail($id);

        return view('admin.news.edit', [
            'news' => $news,
        ]);
    }


    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news->update($request->all());

        return redirect()
            ->to(route('news.index'))
            ->with('success', 'Изменения успешно сохранены');
    }


    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()
            ->to(route('news.index'))
            ->with('success', 'Изменения успешно удалены');
    }
}
