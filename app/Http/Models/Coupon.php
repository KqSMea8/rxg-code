<?php 

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coupon extends Model
{

	protected $table = 'ticket';
	public function sele($userId)
	{
		return $this->select();
	}
}