<?php

namespace KandiData;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model {
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function keywords()
    {
        return $this->hasMany(Keyword::class);
    }
}
