<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignProgress extends Model
{
    protected $table = 'campaign_progress'; // specify because plural of progress is tricky

    protected $fillable = ['campaign_id', 'title', 'description', 'status', 'created_by'];

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
