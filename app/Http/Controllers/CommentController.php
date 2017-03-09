<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    private $commentRepository;
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function index(){
        return view('admin.comment.index');
    }

    public function store(CreateCommentRequest $request ){
        $data = $request->except('_token');
        $data['comment_author_ip'] = $request->getClientIp();
        if ($this->commentRepository->save($data)){
            flash('回复成功.','success');
        }else{
            flash('回复失败.', 'danger');
        }
        return redirect()->back();
    }
}
