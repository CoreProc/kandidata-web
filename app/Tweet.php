<?php

namespace KandiData;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model {
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'twitter_ident' => 'string'
    ];

    public function scopeWithData($q) {
        return $q->has('keywords')
            ->whereNotNull('sentiment')->whereNotNull('sentiment_score')
            ->whereNotNull('feels_anger')->whereNotNull('feels_joy')
            ->whereNotNull('feels_sadness')->whereNotNull('feels_disgust')
            ->whereNotNull('feels_fear');
    }
    
    public function scopeCandidate($q, $i) {
        
        return !empty($i) ? $q->where('candidate_id', $i) : $q;
    }

    public function keywords()
    {
        return $this->hasMany(Keyword::class);
    }
}
