<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentMethodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(UserRole::ADMIN->value) || $user->can('view_any_payment_method');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PaymentMethod $paymentMethod): bool
    {
        return $user->hasRole(UserRole::ADMIN->value) || $user->can('view_payment_method');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::ADMIN->value) || $user->can('create_payment_method');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PaymentMethod $paymentMethod): bool
    {
        return $user->hasRole(UserRole::ADMIN->value) || $user->can('update_payment_method');
    }

    /**
     * Determine whether the user can delete the model.
     * Prevents deletion if referenced by existing registrations.
     */
    public function delete(User $user, PaymentMethod $paymentMethod): bool
    {
        // Must have admin role or delete permission
        if (! ($user->hasRole(UserRole::ADMIN->value) || $user->can('delete_payment_method'))) {
            return false;
        }

        // Prevent deletion if referenced by any registration to protect historical records
        if ($paymentMethod->registrations()->exists()) {
            return false;
        }

        return true;
    }
}
