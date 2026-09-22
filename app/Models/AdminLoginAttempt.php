<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $identifier
 * @property int $attempts
 * @property int $lockout_level
 * @property Carbon|null $locked_until
 */
#[Fillable(['identifier', 'attempts', 'lockout_level', 'locked_until'])]
class AdminLoginAttempt extends Model
{
    protected function casts(): array
    {
        return [
            'locked_until' => 'datetime',
        ];
    }
}
