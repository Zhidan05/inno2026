<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case JUDGE = 'judge';
    case PARTICIPANT = 'participant';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::MODERATOR => 'Moderator',
            self::JUDGE => 'Judge',
            self::PARTICIPANT => 'Participant',
        };
    }

    public function defaultRoute(): string
    {
        return match($this) {
            self::ADMIN, self::MODERATOR, self::JUDGE => '/admin',
            self::PARTICIPANT => '/dashboard',
        };
    }

    public function isBackoffice(): bool
    {
        return match($this) {
            self::ADMIN, self::MODERATOR, self::JUDGE => true,
            self::PARTICIPANT => false,
        };
    }
}
