<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends Controller
{
    //
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(){
        $categorys = $this->categoryRepository->paginate();
        return view('admin.category.index',compact('categorys'));
    }

    public function posts($slug){
        $category = $this->categoryRepository->getCategoryBySlug($slug);
        $posts = $this->categoryRepository->getPostGroupByCategory($category);
        $name = $category->category_name;
        return view('category',compact('posts','name'));
    }

    public function store(CreateCategoryRequest $request){
        $this->categoryRepository->save($request->except('_token'));
        return redirect()->route('category.index');
    }
}
