<?php 
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
class ActivityDrink extends Model
{
public $table="goods_cats";

public function drink($id)
{
$data=$this->where(["parentId"=>$id])->paginate(5);
return $data;

}

}

