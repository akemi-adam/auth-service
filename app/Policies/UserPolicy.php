<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Auth;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     * 
     * @param User $user
     * 
     * @return bool
     */
    public function viewAny(User $user) : bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can view the model.
     * 
     * @param User $user
     * @param User $model
     * 
     * @return bool
     */
    public function view(User $user, User $model) : bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     * 
     * @param User $user
     * @param User $model
     * 
     * @return bool
     */
    public function update(User $user, User $model) : bool
    {
        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 
     * @param User $user
     * @param User $model
     * 
     * @return bool
     */
    public function forceDelete(User $user, User $model) : bool
    {
        return $user->id == $model->id;
    }
}
