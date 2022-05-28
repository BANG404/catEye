<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->create(User::select('user_id','name','email','headImg')->simplepaginate(5),'查找成功','200');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id= $request->session()->get('user');
        $data=User::select('user_id','name','email','headImg')->find($id);
        if($data){
            return $this->create($data,'查找成功','200');
        }else{
            return $this->create(null,'未查找到','400');
        }
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
        $data=User::select('user_id','name','email','headImg')->find($id);
        if($data){
            return $this->create($data,'查找成功','200');
        }else{
            return $this->create(null,'未查找到','400');
        }
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
        $data=$request->all();
        //数据验证
        $validator=\Validator::make($data,[
            'name'=>'required|max:255',
            'password'=>'required|max:255',
            'headImg'=>'required|max:255',
        ]);
        if($validator->fails()){
            return $this->create([],$validator->errors()->first(),'400');
        }
        //数据入库
        $addData=User::where('user_id',$id)->update($data);
        if($addData){
            return $this->create($addData,'更新成功','200');
        }else{
            return $this->create([],'更新失败','400');
        }
    }

    /**
     * Remove the specified resource from storage.
     * 注销账号
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data=User::where('user_id',$id);
        if($data){
            $data->delete();
            return $this->create($data,'注销成功','200');
        }else{
            return $this->create([],'账号未查找到','400');
        }
    }
}