<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usermeta;
use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    public function index()
    {
        $metas = auth()->user()->meta->pluck('meta_value', 'meta_key')->all();

        return view('admin.user.settings', compact('metas'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            Usermeta::updateOrInsert(
                ['meta_key' => $key, 'user_id' => $user->id],
                ['meta_value' => $value]
            );
        }

        return redirect()->back()->with('success', '更新成功');
    }
}
