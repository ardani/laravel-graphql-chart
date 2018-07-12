<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = [
        'message', 'type', 'user_id', 'parent_id'
    ];

    protected $appends = ['social', 'retweet'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSocialAttribute()
    {
        return $this->attributes['type'] == 1 ? 'facebook' : 'twitter';
    }

    public function getRetweetAttribute()
    {
        if ($this->attributes['parent_id'] > 0) {
            return $this->retweet()->first()->message;
        } else {
            return '';
        }
    }

    public function retweet()
    {
        return $this->belongsTo(Feed::class, 'parent_id');
    }


}
