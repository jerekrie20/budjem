<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BudgetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Budget $budget): Response
    {
        //Only the owner of the budget can view it
        return $user->id == $budget->user_id
            ? Response::allow()
            : Response::deny('You are not the owner of this budget');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        //Only if the user is login, they can create a budget
        return $user->id
            ? Response::allow()
            : Response::deny('You are not login');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Budget $budget): Response
    {
        // Only the owner of the budget can update it
        return $user->id == $budget->user_id
            ? Response::allow()
            : Response::deny('You are not the owner of this budget');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Budget $budget): Response
    {
        //Allows deletion if the user is an admin or the owner of the budget
        return $user->admin || $user->id == $budget->user_id
            ? Response::allow()
            : Response::deny('You are not the owner of this budget');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Budget $budget): Response
    {
        //Only admins can restore a budget
        return $user->admin
            ? Response::allow()
            : Response::deny('You are not an admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Budget $budget): Response
    {
        //Only admins can restore a budget
        return $user->admin
            ? Response::allow()
            : Response::deny('You are not an admin');
    }
}
