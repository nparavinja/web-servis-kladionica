<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function team_guest() {
        return $this->belongsTo('App\Team','team_guest_id');
    }

    public function kvote() {
        return $this->hasMany('App\Kvota');
    }


}
