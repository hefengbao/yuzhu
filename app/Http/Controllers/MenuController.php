<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\OptionRepository;
use App\Repositories\PageRepository;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    //
    protected $categoryRepository;
    protected $pageRepository;
    protected $optionRepository;

    public function __construct(CategoryRepository $categoryRepository, PageRepository $pageRepository, OptionRepository $optionRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->pageRepository = $pageRepository;
        $this->optionRepository = $optionRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAll();
        $pages = $this->pageRepository->getAll();
        $menu = $this->optionRepository->getMenu();
        return view('admin.menu.index', compact('categories', 'pages', 'menu'));
    }
}
