<?php

namespace App\Enum;

class UserRole
{
    const SUPERADMIN = 'super_admin';

    const MODERATOR = 'moderator';

    const EDITOR = 'editor';

    const USER = 'user';

    /**
     * @return string[]
     */
    public static function getRoleList(): array
    {
        return [
            self::SUPERADMIN => 'super_admin',
            self::MODERATOR => 'moderator',
            self::EDITOR => 'editor',
            self::USER => 'user',
        ];
    }

    public static function getRoleName(string $role_code): string
    {
        return match ($role_code) {
            self::SUPERADMIN => 'super_admin',
            self::MODERATOR => 'moderator',
            self::EDITOR => 'editor',
            self::USER => 'user',
            default => '',
        };
    }
}
