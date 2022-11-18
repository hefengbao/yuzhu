<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    //
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        if(!Gate::allows('user.index')){
            abort(401);
        }
        $users = $this->userRepository->getAll();
        return view('admin.user.index', compact('users'));
    }

    public function profile($id)
    {
        if(!Gate::allows('user.profile')){
            abort(401);
        }
        $user = $this->userRepository->show($id);
        return view('admin.user.profile', compact('user'));
    }


    public function update($id, UserRequest $request)
    {
        $user = User::findOrFail($id);
        try {
            $request->update($user);
        } catch (\Exception $exception) {
            return "图片上传失败：" . $exception->getMessage();
        }

        return redirect(route('user.profile', $id));
    }

    public function show($id){
        $user = $this->userRepository->show($id);
        return view('user', compact('user'));
    }
}
