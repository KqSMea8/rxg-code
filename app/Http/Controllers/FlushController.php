<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/7/24
 * Time: 17:00
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Redis;

class FlushController extends Controller
{
    public function index()
    {
        Redis::FLUSHALL();
        return redirect('/');
    }
}