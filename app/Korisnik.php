<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Korisnik extends Model
{
    //
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function tiketi() {
        return $this->hasMany('App\Ticket', 'user_id');
    }

}
