<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        $comments = Comment::latest('created_at')->paginate(10);
        return view('admin.comment.index', compact('comments'));
    }

    public function store(CommentRequest $request)
    {
        $data = $request->except('_token');
        $data['comment_author_ip'] = $request->getClientIp();
        if ($this->commentRepository->save($data)) {
            flash('回复成功.', 'success');
        } else {
            flash('回复失败.', 'danger');
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete($id);
        return redirect()->back()->with('success', '删除评论成功！');
    }
}
