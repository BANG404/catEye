<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends BaseController
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
            'name'=>'required|max:255|unique:user',
            'password'=>'required|max:255',
            'headImg'=>'required|max:255',
            'email'=>'required|max:255',
        ]);
        if($validator->fails()){
            return $this->create([],$validator->errors()->first(),'400');
        }
        //数据入库
        $user=new User;
        $user->name=$data['name'];
        $user->password=$data['password'];
        $user->headImg=$data['headImg'];
        $user->email=$data['email'];
        $user->role=0;
        $user->save();
        $user->password=null;
        // $addData=User::create($user);
        return $this->create($user,'注册成功','200');
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
