<?php
/**
 * Author: hefengbao
 * Date: 2016/11/10
 * Time: 14:22
 */

namespace App\Http\ViewComposers;


use App\Repositories\CategoryRepository;
use App\Repositories\OptionRepository;
use App\Repositories\PostRepository;
use Illuminate\View\View;

class MenuComposer
{
      protected $optionRepository;
      protected $postRepository;
      protected $categoryRepository;
      public function __construct(OptionRepository $optionRepository)
      {
          $this->optionRepository = $optionRepository;
      }

      public function compose(View $view){
          $menu =  $this->optionRepository->getMainMenu();
          $view->with('menu',$menu);
      }
}