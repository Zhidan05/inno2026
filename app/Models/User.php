<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use App\Enums\UserRole;

#[Fillable(['name', 'email', 'phone', 'institution', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function judgedCompetitions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Competition::class, 'competition_judge');
    }

    public function defaultRedirectUrl(): string
    {
        if ($this->isBackofficeUser()) {
            return '/admin';
        }

        return '/dashboard';
    }

    public function isBackofficeUser(): bool
    {
        return $this->hasRole([
            UserRole::ADMIN->value,
            UserRole::MODERATOR->value,
            UserRole::JUDGE->value,
        ]);
    }

    public function isParticipant(): bool
    {
        return $this->hasRole(UserRole::PARTICIPANT->value);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'participant') {
            return $this->hasRole(UserRole::PARTICIPANT->value);
        }

        // Only admin, moderator, and judge can access the admin Filament panel.
        return $this->isBackofficeUser();
    }
}
