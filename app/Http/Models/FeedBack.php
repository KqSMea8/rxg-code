<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $table = 'feedback';
    public $timestamps = false;

    public function member()
    {
        return $this->hasOne('App\Http\Models\RxgUser','userId','member_id');
    }
}