<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = [
        'message', 'type', 'user_id', 'parent_id'
    ];

    protected $appends = ['social', 'retweet', 'message_formatted'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSocialAttribute()
    {
        return $this->attributes['type'] == 1 ? 'facebook' : 'twitter';
    }

    public function getMessageFormattedAttribute()
    {
        return $this->attributes['parent_id'] == 0 ? $this->attributes['message'] : $this->retweet()->first()->message;
    }

    public function getRetweetAttribute()
    {
        return $this->attributes['parent_id'] > 0 ? 'true' : 'false';
    }

    public function retweet()
    {
        return $this->belongsTo(Feed::class, 'parent_id');
    }


}
