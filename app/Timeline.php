<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $fillable = [
        'feed_count', 'feed_retweet_count', 'type', 'date'
    ];

    protected $appends = ['social'];

    public $timestamps = false;

    public function getSocialAttribute()
    {
        return $this->attributes['type'] == 1 ? 'facebook' : 'twitter';
    }
}
