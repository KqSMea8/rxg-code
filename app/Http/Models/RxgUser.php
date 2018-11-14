<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class RxgUser extends Model
{
    protected $table = "user";
    public $timestamps = false;
    public function select($table,$id)
    {
        return DB::select("select * from $table where `userId` = $id");
    }
    public static function checkUserLogin($username, $password)
    {
        return self::where(function ($query) use ($username) {
            $query->orwhere('username', $username);
            $query->orwhere('tel', $username);
            $query->orwhere('email', $username);
        })
            ->where('password', $password)
            ->first();
    }

    public static function register($data)
    {
        return self::insert($data);
    }

    public static function checkTelOnly($tel)
    {
        return self::where('tel', $tel)->first();
    }

    public static function checkEmailOnly($email)
    {
        return self::where('email', $email)->first();
    }
  
}