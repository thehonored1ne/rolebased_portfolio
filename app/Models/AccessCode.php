<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AccessCode extends Model
{
    protected $fillable = [
        'code_hash',
        'reset_token',
        'reset_expires_at',
        'failed_attempts',
    ];

    protected function casts(): array
    {
        return [
            'reset_expires_at' => 'datetime',
            'failed_attempts' => 'integer',
        ];
    }

    /**
     * Verify a plain text 6-digit PIN against the active access code.
     */
    public static function checkCode(string $pin): bool
    {
        $active = static::first();

        if (! $active) {
            return false;
        }

        return Hash::check($pin, $active->code_hash);
    }

    /**
     * Set a new PIN for the access code.
     */
    public function updatePin(string $pin): void
    {
        $this->update([
            'code_hash' => Hash::make($pin),
            'reset_token' => null,
            'reset_expires_at' => null,
            'failed_attempts' => 0,
        ]);
    }
}
