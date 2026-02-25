<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'status', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->role === 'admin',
            'agency' => $this->role === 'agency' && $this->status === 'approved',
            'guide' => $this->role === 'guide' && $this->status === 'approved',
            default => false,
        };
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAgency(): bool
    {
        return $this->role === 'agency';
    }

    public function isGuide(): bool
    {
        return $this->role === 'guide';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function guideProfile(): HasOne
    {
        return $this->hasOne(GuideProfile::class);
    }

    public function agencyProfile(): HasOne
    {
        return $this->hasOne(AgencyProfile::class);
    }

    public function tourJobs(): HasMany
    {
        return $this->hasMany(TourJob::class, 'agency_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'guide_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function invoicesAsAgency(): HasMany
    {
        return $this->hasMany(Invoice::class, 'agency_id');
    }

    public function invoicesAsGuide(): HasMany
    {
        return $this->hasMany(Invoice::class, 'guide_id');
    }

    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Review::class, 'agency_id');
    }

    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'guide_id');
    }
}
