<?php
// app/Models/Invitation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

use App\Models\Company;
use App\Models\User;
class Invitation extends Model
{
    protected $fillable = [
        'company_id',
        'invited_by',
        'user_id',
        'role_id',
        'email',
        'name',
        'token',
        'status',
        'expires_at',
        'accepted_at',
        'last_sent_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'last_sent_at' => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class);
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending')
            ->where('expires_at', '>', now());
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    public static function generateToken(): string
    {
        return hash('sha256', Str::random(60));
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending' && !$this->isExpired();
    }

    public function markAccepted(User $user): void
    {
        $this->update([
            'status' => 'accepted',
            'accepted_at' => now(),
            'user_id' => $user->id,
        ]);
    }

    public function refreshToken(): void
    {
        $this->update([
            'token' => self::generateToken(),
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
            'last_sent_at' => now(),
        ]);
    }
}