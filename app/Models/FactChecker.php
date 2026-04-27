<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class FactChecker extends Model
{
    protected $table = 'fact_checker';

    protected $fillable = ['user_id', 'campaign_id', 'vote'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
}
