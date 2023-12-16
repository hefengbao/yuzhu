<?php
/**
 * Author: hefengbao
 * Date: 2016/11/10
 * Time: 14:22
 */

namespace App\Http\ViewComposers;

use App\Services\OptionService2;
use Illuminate\View\View;

class OptionComposer
{
    protected $optionRepository;

    public function __construct(OptionService2 $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function compose(View $view)
    {
        $option = $this->optionRepository->getAll();
        $view->with($option);
    }
}
