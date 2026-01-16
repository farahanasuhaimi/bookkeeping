<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'plan',
        'show_tooltips',
        'tooltip_settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'show_tooltips' => 'boolean',
            'tooltip_settings' => 'array',
        ];
    }

    /**
     * Check if tooltips should be shown for a specific page.
     */
    public function shouldShowTooltip($page): bool
    {
        if (!$this->show_tooltips) {
            return false;
        }

        if (empty($this->tooltip_settings)) {
            return true;
        }

        return $this->tooltip_settings[$page] ?? true;
    }
}
