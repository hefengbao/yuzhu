<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->isAdministrator() || $user->id == $model->id;
    }

    /**
     * 禁止账号
     */
    public function delete(User $user, User $model): bool
    {
        // ID 为 1 的管理员账号不允许禁止
        // 不允许其他管理员禁止自己的账号
        return $user->isAdministrator() && $model->id != 1 && $model->id != $user->id;
    }

    /**
     * 恢复账号
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isAdministrator();
    }

    /**
     * 删除账号
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->isAdministrator();
    }
}
