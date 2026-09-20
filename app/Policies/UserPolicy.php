<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::MODERATOR->value]);
    }

    public function view(User $user, User $model): bool
    {
        if ($user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
            return true;
        }
        if ($user->hasRole(\App\Enums\UserRole::MODERATOR->value)) {
            return $model->hasRole(\App\Enums\UserRole::PARTICIPANT->value);
        }
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole([\App\Enums\UserRole::ADMIN->value, \App\Enums\UserRole::MODERATOR->value]);
    }

    public function update(User $user, User $model): bool
    {
        if ($user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
            return true;
        }
        if ($user->hasRole(\App\Enums\UserRole::MODERATOR->value)) {
            return $model->hasRole(\App\Enums\UserRole::PARTICIPANT->value);
        }
        return false;
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
            if ($model->hasRole(\App\Enums\UserRole::ADMIN->value) && \App\Models\User::role(\App\Enums\UserRole::ADMIN->value)->count() <= 1) {
                return false; // Prevent deleting last admin
            }
            return true;
        }
        if ($user->hasRole(\App\Enums\UserRole::MODERATOR->value)) {
            return $model->hasRole(\App\Enums\UserRole::PARTICIPANT->value);
        }
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasRole(\App\Enums\UserRole::ADMIN->value);
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole(\App\Enums\UserRole::ADMIN->value);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->hasRole(\App\Enums\UserRole::ADMIN->value);
    }

    public function restore(User $user, User $model): bool
    {
        return $user->hasRole(\App\Enums\UserRole::ADMIN->value);
    }

    public function restoreAny(User $user): bool
    {
        return $user->hasRole(\App\Enums\UserRole::ADMIN->value);
    }

    public function replicate(User $user, User $model): bool
    {
        return false;
    }

    public function reorder(User $user): bool
    {
        return false;
    }
}
