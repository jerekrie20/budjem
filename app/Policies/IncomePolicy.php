<?php

namespace App\Policies;

use App\Models\Income;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IncomePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Income $income): Response
    {
        //Only the owner of the income can view it
        return $user->id == $income->user_id
            ? Response::allow()
            : Response::deny('You are not the owner of this income');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        //If the user is login, they can create an income
        return $user->id
            ? Response::allow()
            : Response::deny('You are not login');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Income $income): Response
    {
        //If the income belongs to that user, they can update it
        return $user->id == $income->user_id
            ? Response::allow()
            : Response::deny('You are not the owner of this income');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Income $income): Response
    {
        //Allows deletion if the user is an admin or the owner of the income
        return $user->admin || $user->id == $income->user_id
            ? Response::allow()
            : Response::deny('You are not the owner of this income');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Income $income): Response
    {
        //Only for admin
        return $user->admin
            ? Response::allow()
            : Response::deny('You are not an admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Income $income): Response
    {
        //Only for admin
        return $user->admin
            ? Response::allow()
            : Response::deny('You are not an admin');
    }
}
