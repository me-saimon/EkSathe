<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name', 'email', 'password', 'phone', 'avatar',
        'status', 'verified_at', 'is_volunteer', 'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Relationships
    public function campaigns() {
        return $this->hasMany(Campaign::class, 'creator_by');
    }

    public function donations() {
        return $this->hasMany(Donation::class);
    }

    public function applications() {
        return $this->hasMany(VolunteerApplication::class);
    }

    public function helpRequests() {
        return $this->hasMany(HelpRequest::class);
    }

    // Helper to check role
    public function isAdmin() {
        return $this->role === 'admin';
    }
}
