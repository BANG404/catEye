<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data=$request->all();
        //数据验证
        $validator=\Validator::make($data,[
            'name'=>'required|max:255',
            'password'=>'required|max:255',
        ]);
        if($validator->fails()){
            return $this->create([],$validator->errors()->first(),'400');
        }
        //数据入库
        $user=User::where('name',$data['name'])->first();
        if(!$user){
            return $this->create([],$data['name'].'用户不存在','400');
        }
        if($user->password!=$data['password']){
            return $this->create([],$data['name'].'密码错误','400');
        }
        $user->password=null;
        // session_start();
        $request->session()->put('user',$user);
        // session(['user'=>$user]);
        return $this->create($user,'登录成功','200');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
