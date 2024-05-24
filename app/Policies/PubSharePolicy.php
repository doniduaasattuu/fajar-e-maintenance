<?php

namespace App\Policies;

use App\Models\PubShare;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PubSharePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PubShare $pubShare): bool
    {
        if ($user->nik == $pubShare->nik) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PubShare $pubShare): bool
    {
        if ($user->nik == $pubShare->nik) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PubShare $pubShare): bool
    {
        if ($user->nik == $pubShare->nik) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PubShare $pubShare): bool
    {
        if ($user->nik == $pubShare->nik) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PubShare $pubShare): bool
    {
        if ($user->nik == $pubShare->nik) {
            return true;
        } else {
            return false;
        }
    }
}
