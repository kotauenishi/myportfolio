<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buying_order extends Model
{
    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
