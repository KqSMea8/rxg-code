<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Ticket extends Model
{
	protected $table="ticket";
    public $timestamps = false;
    
    public function insertData($data)
    {
    	return self::insert($data);
    }
    public static function getUser($where=[])
    {
        return self::where($where)->first();
    }
    
    public static function getPs($where)
    {
        return self::where($where)->get();
    }
    public static function ticketDel($where)
    {
        return self::where($where)->delete();
    }
}
