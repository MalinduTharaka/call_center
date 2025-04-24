<?php

namespace App\Enums;

enum TargetStatusEnum: int
{
    case PENDING = 1;
    case COMPLETED = 2;

    public function toString(): string
    {
        return match ($this) {
            self::PENDING => 'Pending Complete',
            self::COMPLETED => 'Completed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::COMPLETED => 'success',
        };
    }
}
