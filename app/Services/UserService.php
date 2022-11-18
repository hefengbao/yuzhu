<?php

namespace App\Services;


use App\Models\User;

class UserService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        return $this->user->findOrFail($id);
    }

    public function getAll()
    {
        return $this->user->paginate(10);
    }
}
