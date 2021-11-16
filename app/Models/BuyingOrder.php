<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyingOrder extends Model
{
    protected $guarded = array('id');

    /**
     * Buying_orders多：Users1の結合が行われているメソッド
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
