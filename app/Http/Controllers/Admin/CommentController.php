<?php

namespace App\Http\Controllers\Admin;

use App\Constant\CommentStatus;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $authUser */
        $authUser = auth()->user();

        $query = Comment::with(['post', 'author'])->when($authUser->isAuthor(), function ($q) use ($authUser) {
            // 既不是管理员也不是编辑,则只查询该作者发布的的评论
            return $q->where('user_id', $authUser->id);
        });

        $total = $query->clone()->count('id');
        $myTotal = $query->clone()->where('user_id', $authUser->id)->count('id');
        $pendingTotal = $query->clone()->where('status', CommentStatus::Pending->value)->count('id');
        $approvedTotal = $query->clone()->where('status', CommentStatus::Approved->value)->count('id');
        $spamTotal = $query->clone()->where('status', CommentStatus::Spam->value)->count('id');
        $trashTotal = $query->clone()->where('status', CommentStatus::Trash->value)->count('id');
        $comments = $query->when($request->query('status'), function ($q) use ($request) {
            return $q->where('status', $request->query('status'));
        })->when($request->query('author'), function ($q) use ($request, $authUser) {
            if ($authUser->isAuthor() && $request->query('author') != $authUser->id) {
                abort(403);
            }
            return $q->where('user_id', $request->query('author'));
        })->latest('id')
            ->paginate(15)
            ->withQueryString();

        $metrics = [
            'total' => $total,
            'my_total' => $myTotal,
            'approved_total' => $approvedTotal,
            'pending_total' => $pendingTotal,
            'spam_total' => $spamTotal,
            'trash_total' => $trashTotal
        ];

        return view('admin.comment.index', compact('comments', 'metrics', 'authUser'));
    }

    public function trash($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = CommentStatus::Trash->value;
        $comment->save();

        return redirect()->back()->with('success', '已移至回收站');
    }

    public function spam($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = CommentStatus::Spam->value;
        $comment->save();

        return redirect()->back()->with('success', '已标记为垃圾');
    }

    public function pending($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = CommentStatus::Pending->value;
        $comment->save();

        return redirect()->back()->with('success', '已驳回');
    }

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = CommentStatus::Approved->value;
        $comment->save();

        return redirect()->back()->with('success', '已批准');
    }

    public function restore($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = CommentStatus::Pending->value;
        $comment->save();

        return redirect()->back()->with('success', '已还原到待审');
    }
}
