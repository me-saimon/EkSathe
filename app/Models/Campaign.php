<?php
namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'creator_by', 'category', 'title', 'description', 'campaign_date',
        'goal_amount', 'live_video_url', 'address', 'location_map',
        'rank', 'banner_image', 'is_volunteer_need', 'status'
    ];

    protected $casts = [
        'campaign_date' => 'datetime',
        'goal_amount' => 'decimal:2',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'creator_by');
    }

    public function donations() {
        return $this->hasMany(Donation::class);
    }

    public function volunteerApplications() {
        return $this->hasMany(VolunteerApplication::class);
    }

    public function progressUpdates() {
        return $this->hasMany(CampaignProgress::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function factChecks() {
        return $this->hasMany(FactChecker::class);
    }
}
