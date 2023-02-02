<?php

namespace App\Http\Controllers;

use App\Constant\CommentStatus;
use App\Jobs\RepliedNotification;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    public function store($slugId, Request $request)
    {
        $id = extract_id($slugId);

        $post = Post::findOrFail($id);

        $rules = [
            'body' => ['required'],
        ];

        if (!$request->user()) {
            $rules = array_merge($rules, [
                'name' => ['required'],
                'email' => ['required', 'email:rfc,dns']
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

        $comment->status = CommentStatus::Approved->value;

        $comment->save();

        //通知
        RepliedNotification::dispatch($comment);

        return redirect(url()->previous() . '#comment-' . $comment->id)->with('success', '评论添加成功');
    }
}
