<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    //
    protected $table = 'par';
    protected $primaryKey = 'id';

    public function tiket() {
        return $this->belongsTo('App\Ticket');
    }

    public function kvota() {
        return $this->belongsTo('App\Kvota','kvota_id');
    }

    public function utakmica() {
        return $this->belongsTo('App\Game','game_id');
    }


}
