<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Cache;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }

        $options = $this->getOptions();

        return view('admin.option.index', compact('options'));
    }

    private function getOptions(): array
    {
        return Option::get()->pluck('value', 'name')->toArray();
    }

    public function store(Request $request)
    {
        foreach ($request->except('_token') as $item => $value) {
            Option::updateOrCreate(['name' => $item], ['value' => $value,'autoload' => 'yes']);
        }

        Cache::forget('autoload_options');

        return redirect()->back()->with('success', '保存成功');
    }
}
