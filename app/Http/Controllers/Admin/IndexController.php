<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Power;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index()
    {
    	
        return view('admin.index.index');
    }
}