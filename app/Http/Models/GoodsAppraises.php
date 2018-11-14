<?php 
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class GoodsAppraises extends Model
{

	protected $table='goods_appraises';

	public function addData($data){
		return GoodsAppraises::insert($data);
	}

}