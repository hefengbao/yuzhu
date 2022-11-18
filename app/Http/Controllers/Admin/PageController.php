<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Repositories\PageRepository;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    //
    protected $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function index()
    {
        if (!Gate::allows('page.index')) {
            abort(401);
        }
        $pages = $this->pageRepository->adminPaginate();
        return view('admin.page.index', compact('pages'));
    }

    public function create()
    {
        if (!Gate::allows('page.create')) {
            abort(401);
        }
        return view('admin.page.create');
    }

    public function store(PostRequest $request)
    {
        $this->pageRepository->save($request->except('_token'));
        return redirect('admin/page');
    }

    public function edit($id)
    {
        if (!Gate::allows('page.edit')) {
            abort(401);
        }
        $page = $this->pageRepository->findById($id);
        return view('admin.page.edit', compact('page'));
    }

    public function show($slug)
    {
        $page = $this->pageRepository->show($slug);
        return view('page', compact('page'));
    }

    public function update(PostRequest $request, $id)
    {
        $this->pageRepository->update($id, $request->except('_token'));
        return redirect('admin/page');
    }

    public function destroy($id)
    {
        if (!Gate::allows('page.destroy')) {
            abort(401);
        }
        $this->pageRepository->delete($id);
        return redirect()->back()->with('success', '删除页面成功！');
    }
}
