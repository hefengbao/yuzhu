<?php

namespace App\Http\Controllers\Admin;

use App\Constant\Commentable;
use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TweetRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TweetController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $authUser */
        $authUser = auth()->user();

        $query = Post::with(['author', 'tags'])
            ->withCount(['comments'])
            ->tweet()
            ->when($authUser->isAuthor(), function ($q) use ($authUser) {
                return $q->where('user_id', $authUser->id);
            });

        $total = $query->clone()->count('id');

        if (!$authUser->isAuthor()) {
            $myTotal = $query->clone()->where('user_id', $authUser->id)->count('id');
        }

        $publishTotal = $query->clone()->where('status', 'publish')->count('id');
        $trashTotal = $query->clone()->where('status', 'trash')->count('id');

        $tweets = $query->when($request->query('status'), function ($q) use ($request) {
            return $q->where('status', $request->query('status'));
        })->when($request->query('author'), function ($q) use ($request) {
            return $q->where('user_id', $request->query('author'));
        })->orderByDesc('id')->paginate(10);

        $metrics = [
            'total' => $total,
            'my_total' => $myTotal ?? 0,
            'publish_total' => $publishTotal,
            'trash_total' => $trashTotal
        ];

        return view('admin.tweet.index', compact('tweets', 'metrics'));
    }

    public function create()
    {
        $tags = Tag::orderByDesc('id')->get();
        return view('admin.tweet.create', compact('tags'));
    }

    public function store(TweetRequest $request)
    {
        $auth = $request->user();
        $tweet = new Post();
        $tweet->author()->associate($auth);
        $tweet->type = PostType::Tweet->value;
        $tweet->status = PostStatus::Publish->value;
        $tweet->body = $request->input('body');
        $tweet->slug = post_slug(Str::substr($tweet->body,0,20));
        $tweet->commentable = $request->input('commentable') ?: Commentable::Open->value;
        $tweet->published_at = Carbon::now();
        $tweet->save();

        if ($request->input('tag')) {
            $tagIds = [];
            foreach ($request->input('tag') as $name) {
                $tag = Tag::firstOrCreate([
                    'name' => $name
                ], [
                    'slug' => Str::slug($name, '-', 'zh_CN')
                ]);

                $tagIds[] = $tag->id;
            }
            $tweet->tags()->attach($tagIds);
        }

        return redirect()->route('admin.tweets.index')->with('success', '保存成功');
    }

    public function edit($id)
    {
        $tweet = Post::with(['tags'])->findOrFail($id);
        $tags = Tag::orderByDesc('id')->get();
        $pre = url()->previous();
        return view('admin.tweet.edit', compact('tweet', 'tags', 'pre'));
    }

    public function update($id, Request $request)
    {
        /** @var Post $tweet */
        $tweet = Post::with(['tags'])->findOrFail($id);
        $tweet->body = $request->input('body');
        $tweet->commentable = $request->input('commentable') ?: Commentable::Open->value;
        $tweet->save();

        if ($request->input('tag')) {
            $tagIds = [];
            foreach ($request->input('tag') as $name) {
                $tag = Tag::firstOrCreate([
                    'name' => $name
                ], [
                    'slug' => Str::slug($name, '-', 'zh_CN')
                ]);

                $tagIds[] = $tag->id;
            }
            $tweet->tags()->sync($tagIds);
        } else {
            $tweet->tags()->detach();
        }

        return redirect()->route('admin.tweets.index')->with('success', '修改成功');
    }

    public function destroy($id)
    {
        $tweet = Post::tweet()->findOrFail($id);
        $tweet->status = PostStatus::Trash->value;
        $tweet->save();

        return redirect()->route('admin.tweets.index')->with('success', '已移至回收站');
    }
}
