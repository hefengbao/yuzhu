<?php

namespace App\Http\Controllers;

use App\Constant\CMS\CommentStatus;
use App\Jobs\RepliedNotification;
use App\Models\CMS\Comment;
use App\Models\CMS\Post;
use App\Models\Settings\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CommentController extends Controller
{
    public function store($slugId, Request $request)
    {
        $id = extract_id($slugId);

        $post = Post::findOrFail($id);

        $rules = [
            'body' => ['required'],
        ];

        // 访客需要提供用户名和邮件地址
        if (!$request->user()) {
            $rules = array_merge($rules, [
                'name' => ['required'],
                'email' => ['required', 'email:rfc,dns'],
            ]);
        }

        $validator = Validator::make($request->all(), $rules, [
            'body.required' => '评论不能为空',
            'name.required' => '显示名称不能为空',
            'email.required' => '电子邮箱不能为空',
            'email.email' => '电子邮箱无效',
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous() . '#respond')
                ->withErrors($validator)
                ->withInput();
        }

        // IP 或 Email 在黑名单中
        if (Blacklist::where('body', $request->ip())->orWhere('body', $request->input('email'))->first()) {
            abort(500);
        }

        // 同一 IP 地址内容相同
        if (cache($request->ip()) == md5($request->input('body'))) {
            abort(500);
        }

        // 内容 MD5 在黑名单中
        if (Blacklist::where('body', md5($request->input('body')))->first()) {
            abort(500);
        }

        $comment = new Comment();
        $comment->body = $request->input('body');
        $comment->ip = $request->ip();
        $comment->user_agent = $request->userAgent();

        $comment->post()->associate($post);

        if ($request->user()) {
            $comment->author()->associate($request->user());
        } else {
            $comment->guest_email = $request->input('email');
            $comment->guest_name = $request->input('name');
        }

        if ($request->input('parent')) {
            $parent = $post->comments()->where('id', $request->input('parent'))->first();
            if ($parent) {
                $comment->parent()->associate($parent);
            }
        }

        // 含有链接的评论需审核后显示
        if (Str::contains($request->input('body'), ['http://', 'https://'])) {
            $comment->status = CommentStatus::Pending;
        } else {
            $comment->status = CommentStatus::Approved;
        }


        DB::transaction(function () use ($comment, $post) {
            $comment->save();
            $post->increment('comment_count');
        });

        // 根据 IP 地址缓存内容 MD5
        cache([$request->ip() => md5($request->input('body'))], now()->addDays());

        //通知
        RepliedNotification::dispatch($comment);

        return redirect(url()->previous() . '#comment-' . $comment->id)->with('success', '评论添加成功');
    }
}
