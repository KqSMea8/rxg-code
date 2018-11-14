<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'goods_comment';
    public $timestamps = false;
}