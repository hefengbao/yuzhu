<?php

namespace App\Http\Controllers;

use App\Repositories\OptionRepository;
use Illuminate\Http\Request;
use Cache;

class OptionController extends Controller
{
    //
    protected $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function index()
    {
        $option = $this->optionRepository->getAll();
        return view('admin.option.index')->with('option', $option);
    }

    public function store(Request $request)
    {
        $save = $this->optionRepository->save($request->except(['_token']));
        if ($save) {
            return redirect()->route('option.index');
        }
    }

    public function menuStore(Request $request)
    {
        $data = $request->except('_token');
        return $this->optionRepository->save($data);
    }

    public function cache()
    {
        return view('admin.option.cache');
    }

    public function clearAllCache()
    {
        if (Cache::flush()) {
            return '清除缓存成功！';
        } else {
            return '清除缓存失败！';
        }
    }
}
