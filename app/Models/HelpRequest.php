<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class HelpRequest extends Model
{
    protected $fillable = [
        'user_id', 'subject', 'message', 'location', 'contact_info', 'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
