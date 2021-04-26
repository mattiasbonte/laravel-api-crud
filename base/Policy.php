<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BASE_Upper_singular;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class BASE_Upper_singularPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user The user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user The user
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The BASE_lower_singular
     *
     * @return mixed
     */
    public function view(User $user, BASE_Upper_singular $BASE_lower_singular)
    {
        return true // TODO CRUD ADD POLICY CHECK HERE
            ? Response::allow()
            : Response::deny('Unauthorized: You cannot view this BASE_lower_singular.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user The user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true // TODO CRUD ADD POLICY CHECK HERE
            ? Response::allow()
            : Response::deny('Unauthorized: You cannot create a new BASE_lower_singular.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user The user
     * @param \App\Models\BASE_Upper_singular_singular $BASE_lower_singular The BASE_lower_singular
     *
     * @return mixed
     */
    public function update(User $user, BASE_Upper_singular $BASE_lower_singular)
    {
        return true // TODO CRUD ADD POLICY CHECK HERE
            ? Response::allow()
            : Response::deny('Unauthorized: You cannot edit this BASE_lower_singular.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user The user
     * @param \App\Models\BASE_Upper_singular_singular $BASE_lower_singular The BASE_lower_singular
     *
     * @return mixed
     */
    public function delete(User $user, BASE_Upper_singular $BASE_lower_singular)
    {
        return true // TODO CRUD ADD POLICY CHECK HERE
            ? Response::allow()
            : Response::deny('Unauthorized: You cannot delete this BASE_lower_singular.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user The user
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The BASE_lower_singular
     *
     * @return mixed
     */
    public function restore(User $user, BASE_Upper_singular $BASE_lower_singular)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user The user
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The BASE_lower_singular
     *
     * @return mixed
     */
    public function forceDelete(User $user, BASE_Upper_singular $BASE_lower_singular)
    {
        //
    }
}
