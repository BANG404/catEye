<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * api基类
 */
class BaseController extends Controller
{
    //
    protected function create($data,$msg='',$code=200)
    {
        $result=[
            //状态码
            'code'=>$code,
            //自定义信息
            'msg'=>$msg,
            //数据返回
            'data'=>$data
        ];
        return response()->json($result);
    }
}
