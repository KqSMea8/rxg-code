<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Models\Ticket;
use Illuminate\Support\Facades\Validator;
class TicketController extends Controller
{
	//展示页面
	public function ticketList()
	{
		$keyword = Request::get('keyword');
		$model = new Ticket();
//		var_dump($model);die;
		$sql = $model->where('name','like','%'.$keyword.'%')->Orwhere('ticket_money','like','%'.$keyword.'%')->paginate(10);
    	$sql->appends(['keyword' => $keyword]);
		return view('admin.ticket.ticketList',['data' => $sql,'keyword' => $keyword]);
	}
	
	public function ticketAdd()
    {
        return view('admin.ticket.ticketAdd');
    }
    
        public function ticketAdddo()
    {
        $data = Request::post();
        $rules = [
            'name' => 'required',
            'ticket_money' => 'required',
            'start_Time' => 'required',
            'end_Time' => 'required',
        ];
        $message = [
            'name.required' => '优惠券名称必填',
            'ticket_money.required' => '优惠金额必填',
            'start_Time.required' => '开始时间必填',
            'end_Time.required' => '结束时间必填',
        ];
        $validate = Validator::make($data, $rules, $message);
        if ($validate->fails()) {
            $errors = $validate->errors()->toArray();
            foreach ($errors as $k => $v) {
                return response()->json([
                    'code' => 2,
                    'message' => $errors[$k][0]
                ]);
            }
        }
        unset($data['_token']);
        $addRes = ticket::insert($data);
        if ($addRes) {
            return response()->json([
                'code' => 1,
                'message' => '添加成功'
            ]);
        } else {
            return response()->json([
                'code' => 2,
                'message' => '添加失败'
            ]);
        }
	}
	
	public function ticketEdit()
	{
		if (Request::isMethod('post')) {
            $data = Request::post();
//          var_dump($data);die;
        $rules = [
            'name' => 'required',
            'ticket_money' => 'required',
            'start_Time' => 'required',
            'end_Time' => 'required',
        ];
        $message = [
            'name.required' => '优惠券名称必填',
            'ticket_money.required' => '优惠金额必填',
            'start_Time.required' => '开始时间必填',
            'end_Time.required' => '结束时间必填',
        ];
        $validate = Validator::make($data, $rules, $message);
        if ($validate->fails()) {
            $errors = $validate->errors()->toArray();
            var_dump($errors);die;
            foreach ($errors as $k => $v) {
                return response()->json([
                    'code' => 2,
                    'message' => $errors[$k][0]
                ]);
            }
        }
        unset($data['_token']);
        $id = $data['id'];
        unset($data['id']);
        $updRes = Ticket::where('id', $id)->update($data);
        if ($updRes) {
            return response()->json([
               	'code' => 1,
                'message' => '修改成功'
            ]);
        } else {
            return response()->json([
                'code' => 2,
                'message' => '修改失败'
            ]);
        }
        } else {
            $id = Request::get('id');
            $ticketInfo = Ticket::getUser(['id' => $id]);
            $ticketList = Ticket::getPs(['id' => 0]);
            return view('admin.ticket.ticketedit', [
                'ticketList' => $ticketList,
                'ticketInfo' => $ticketInfo
            ]);
        }
	}
	public function ticketDel()
    {
        $id = Request::get('id');
        $delRes = Ticket::ticketDel(['id' => $id]);
        if ($delRes) {
            return response()->json([
                'code' => 1,
                'message' => '删除成功'
            ]);
        } else {
            return response()->json([
                'code' => 2,
                'message' => '删除失败'
            ]);
        }
    }
}
