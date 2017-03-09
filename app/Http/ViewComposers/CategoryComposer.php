<?php
/**
 * Author: hefengbao
 * Date: 2016/11/10
 * Time: 14:50
 */

namespace App\Http\ViewComposers;


use App\Repositories\CategoryRepository;
use Illuminate\View\View;

class CategoryComposer
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function compose(View $view){
        $categorys = $this->categoryRepository->getAll();

        $view->with('categorys',$categorys);
    }

}