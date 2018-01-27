<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\User;

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
        $users = $this->userRepository->getAll();
        return view('admin.user.index', compact('users'));
    }

    public function profile($id)
    {
        $user = $this->userRepository->show($id);
        return view('admin.user.profile', compact('user'));
    }


    public function update($id, UpdateUserRequest $request)
    {
        $user = User::findOrFail($id);
        try {
            $request->update($user);
        } catch (ImageUploadException $exception) {
            return "图片上传失败：" + $exception->getMessage();
        }

        return redirect(route('user.profile', $id));
    }
}
