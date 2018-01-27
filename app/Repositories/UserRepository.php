<?php
/**
 * Author: hefengbao
 * Date: 2016/11/21
 * Time: 11:59
 */

namespace App\Repositories;

use App\User;
use Auth;

class UserRepository
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