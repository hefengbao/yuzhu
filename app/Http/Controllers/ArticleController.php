<?php

namespace App\Http\Controllers;

use App\Constant\Editor;
use App\Models\Post;
use App\One\EditorJs\Facades\LaravelEditorJs;
use GrahamCampbell\Markdown\Facades\Markdown;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Post::article()
            ->published()
            ->whereNull('pinned_at')
            ->orderByDesc('published_at')
            ->paginate(10);

        $pinnedArticles = Post::with(['author', 'categories'])
            ->article()
            ->published()
            ->whereNotNull('pinned_at')
            ->orderByDesc('published_at')
            ->get();

        return view('themes.default.article.index', compact('articles', 'pinnedArticles'));
    }

    public function show($slugId)
    {
        $id = extract_id($slugId);

        $article = Post::with(['author', 'categories', 'tags', 'meta'])
            ->article()
            ->findOrFail($id);

        $prev = Post::select(['id', 'title', 'slug'])->find($this->getPrevArticleId($article->id));
        $next = Post::select(['id', 'title', 'slug'])->find($this->getNextArticleId($article->id));

        return view('themes.default.article.show', compact('article', 'prev', 'next'));
    }

    protected function getPrevArticleId($id)
    {
        return Post::article()->published()->where('id', '<', $id)->max('id');
    }

    protected function getNextArticleId($id)
    {
        return Post::article()->published()->where('id', '>', $id)->min('id');
    }
}
