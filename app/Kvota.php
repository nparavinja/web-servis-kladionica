<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kvota extends Model
{
    //
    protected $table = 'kvote';
    protected $primaryKey = 'id';

    public function tiket() {
        return $this->belongsTo('App\Tiket');
    }
}
