<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerApplication extends Model
{
    protected $fillable = ['user_id', 'campaign_id', 'application_notes', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
}
