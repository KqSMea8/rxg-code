<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Advertising extends Model
{
	protected $table = "advertising";
	//添加
	public function inset($table,$data)
	{
		return DB::table($table)->insert($data);
	}
	//查询
	public function select($table)
	{
		return DB::select("select * from $table");
	}
	public function seek($uname)
	{
		return $this->leftjoin('province','province.id','advertising.province')
					->where("uname","like","%$uname%")
					->paginate(10);
	}
	public function sele()
	{
		$data = $this->leftjoin('province','province.id','advertising.province')
					 ->paginate(10);
		return $data;
	}
	//删除
	public function dele($table,$where)
	{
		return DB::delete("delete from $table where $where");
	}
	public function delet($table,$where)
	{
		return DB::delete("delete from $table where $where");
	}
	//修改展示
	public function find($table,$where)
	{
		return DB::select("select * from $table where $where");
	}
	//修改
	public function up($table,$data,$where)
	{
		return DB::table($table)->where($where)->update($data);
	}
	
	public function upda($table,$data,$where)
    {
     	return DB::table($table)->where($where)->update($data);
    }

}