<?php 
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyBack extends Model
{

	protected $table = 'money_back';
	public $timestamps=false;

	public function addData($data)
	{
		self::insert($data);
	}

}
