<?php 

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Consult extends Model
{
	protected $table = "activity";
	public function show($table)
	{
		return DB::table($table)->paginate(10);
	}
	public function sele($uname)
	{
		return $this->where("activityName","like","%$uname%")
					->paginate(10);
	}
}
