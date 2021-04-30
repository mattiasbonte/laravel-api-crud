<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NEST_Upper_singular;
use App\Models\BASE_Upper_singular;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class BASE_Upper_singularPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create a new BASE_lower_singular for the NEST_lower_singular.
     *
     * @param \App\Models\User     $user     The authenticated user
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The requested BASE_lower_singular
     * @param \App\Models\NEST_Upper_singular  $NEST_lower_singular  The NEST_lower_singular
     *
     * @return Illuminate\Auth\Access\Response
     */
    public function create(User $user, BASE_Upper_singular $BASE_lower_singular, NEST_Upper_singular $NEST_lower_singular)
    {
        return $user->NEST_lower_plural->contains($NEST_lower_singular) && $user->isAdmin($NEST_lower_singular)
            || $user->NEST_lower_plural->contains($NEST_lower_singular) && $user->isManager($NEST_lower_singular)
            ? Response::allow()
            : Response::deny('Unauthorized: You cannot create a new BASE_lower_singular for this NEST_lower_singular.');
    }

    /**
     * Determine whether the user can view all the BASE_lower_plural for the NEST_lower_singular.
     *
     * @param \App\Models\User     $user     The authenticated user
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The requested BASE_lower_singular
     * @param \App\Models\NEST_Upper_singular  $NEST_lower_singular  The NEST_lower_singular
     *
     * @return Illuminate\Auth\Access\Response
     */
    public function viewAny(User $user, BASE_Upper_singular $BASE_lower_singular, NEST_Upper_singular $NEST_lower_singular)
    {
        return $user->NEST_lower_plural->contains($NEST_lower_singular)
            ? Response::allow()
            : Response::deny('Unauthorized: You cannot see the tags for this NEST_lower_singular.');
    }

    /**
     * Determine whether the user can view the BASE_lower_singular for the NEST_lower_singular.
     *
     * @param \App\Models\User     $user     The authenticated user
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The requested BASE_lower_singular
     * @param \App\Models\NEST_Upper_singular  $NEST_lower_singular  The NEST_lower_singular
     *
     * @return Illuminate\Auth\Access\Response
     */
    public function view(User $user, BASE_Upper_singular $BASE_lower_singular, NEST_Upper_singular $NEST_lower_singular)
    {
        return $user->NEST_lower_plural->contains($NEST_lower_singular)
            ? Response::allow()
            : Response::deny('Unauthorized: You cannot see the BASE_lower_singular for this NEST_lower_singular.');
    }

    /**
     * Determine whether the user can update the BASE_lower_singular for the NEST_lower_singular.
     *
     * @param \App\Models\User     $user     The authenticated user
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The requested BASE_lower_singular
     * @param \App\Models\NEST_Upper_singular  $NEST_lower_singular  The NEST_lower_singular
     *
     * @return Illuminate\Auth\Access\Response
     */
    public function update(User $user, BASE_Upper_singular $BASE_lower_singular, NEST_Upper_singular $NEST_lower_singular)
    {
        return $user->NEST_lower_plural->contains($NEST_lower_singular) && $user->isAdmin($NEST_lower_singular)
            || $user->NEST_lower_plural->contains($NEST_lower_singular) && $user->isManager($NEST_lower_singular)
            ? Response::allow()
            : Response::deny('Unauthorized: You cannot update this BASE_lower_singular for this NEST_lower_singular.');
    }

    /**
     * Determine whether the user can delete the BASE_lower_singular for the NEST_lower_singular.
     *
     * @param \App\Models\User     $user     The authenticated user
     * @param \App\Models\BASE_Upper_singular $BASE_lower_singular The requested BASE_lower_singular
     * @param \App\Models\NEST_Upper_singular  $NEST_lower_singular  The NEST_lower_singular
     *
     * @return Illuminate\Auth\Access\Response
     */
    public function delete(User $user, BASE_Upper_singular $BASE_lower_singular, NEST_Upper_singular $NEST_lower_singular)
    {
        return $user->NEST_lower_plural->contains($NEST_lower_singular) && $user->isAdmin($NEST_lower_singular)
            || $user->NEST_lower_plural->contains($NEST_lower_singular) && $user->isManager($NEST_lower_singular)
            ? Response::allow()
            : Response::deny('Unauthorized: You cannot delete this BASE_lower_singular for this NEST_lower_singular.');
    }
}
