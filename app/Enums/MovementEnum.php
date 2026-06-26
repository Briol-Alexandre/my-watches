<?php

namespace App\Enums;

enum MovementEnum: string
{
    case Manual = 'manual';
    case Automatic = 'automatic';
    case Quartz = 'quartz';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Manual => 'Manuel',
            self::Automatic => 'Automatique',
            self::Quartz => 'Quartz',
        };
    }
}
