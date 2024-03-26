<?php

namespace App\Http\Controllers\Admin;

use App\Constant\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }
        $query = User::query();
        $total = $query->clone()->count('id');
        $administratorTotal = $query->clone()->where('role', Role::Administrator->value)->count('id');
        $editorTotal = $query->clone()->where('role', Role::Editor->value)->count('id');
        $authorTotal = $query->clone()->where('role', Role::Author->value)->count('id');
        $trashed_total = $query->clone()->onlyTrashed()->count('id');

        $users = $query->when($request->query('role'), function ($q) use ($request) {
            $q->where('role', $request->query('role'));
        })->when($request->query('trashed'), function ($q) {
            $q->onlyTrashed();
        })->latest('id')->paginate(15)->withQueryString();

        $metrics = [
            'total' => $total,
            'administrator_total' => $administratorTotal,
            'editor_total' => $editorTotal,
            'author_total' => $authorTotal,
            'trashed_total' => $trashed_total,
        ];

        return view('admin.user.index', compact('users', 'metrics'));
    }

    public function create()
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }

        return view('admin.user.create');
    }

    public function edit($id)
    {
        /** @var User $authUser */
        $authUser = auth()->user();
        if (!$authUser->isAdministrator() && $authUser->id != $id) {
            abort(403);
        }
        $user = User::findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }

    public function update($id, UserUpdateRequest $request)
    {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $ext = $file->getClientOriginalExtension();

            $folder = 'upload/avatars/';

            if (!is_dir(\Storage::disk('public')->path($folder))) {
                mkdir(Storage::disk('public')->path($folder), 0777, true);
            }

            $path = $folder . Str::random(40) . '.' . $ext;

            $image = \Image::make($file);

            $image->resize(250, 250)->save(\Storage::disk('public')->path($path));

            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $path;
        }

        if ($request->input('bio')) {
            $user->bio = $request->input('bio');
        }

        if ($request->input('role')) {
            $user->role = $request->input('role');
        }

        $user->save();

        return redirect()->route('admin.users.edit', $id)->with('success', '更新成功');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }

        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = \Hash::make($request->input('password'));
        $user->role = $request->input('role') ?? Role::Author->value;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', '用户添加成功');
    }

    public function destroy($id)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', '删除成功');
    }

    public function restore($id)
    {
        if (!auth()->user()->isAdministrator()) {
            abort(403);
        }
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.index')->with('success', '恢复成功');
    }
}
