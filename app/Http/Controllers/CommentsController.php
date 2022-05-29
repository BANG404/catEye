<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Comments;

class CommentsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->create(Comments::select('comments_id','movie_id','comments','user_id')->orderby('comments_id','desc')->simplepaginate(5),'查找成功','200');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //添加评论
        $data=$request->all();
        //数据验证
        $validator=\Validator::make($data,[
            'movie_id'=>'required|max:255',
            'user_id'=>'required|max:255',
            'comments'=>'required|max:255',
        ]);
        if($validator->fails()){
            return $this->create([],$validator->errors()->first(),'400');
        }
        //判断电影是否存在
        $movie=Movie::find($data['movie_id']);
        if(!$movie){
            return $this->create(null,'该电影不存在','400');
        }
        //数据入库
        $addData=Comments::create($data);
        if($addData){
            return $this->create([],$addData,'200');
        }else{
            return $this->create([],$addData,'400');
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
        $data=Comments::find($id);
        //判断删除的评论是否是登录用户的
        if($data->user_id!=$this->user_id){
            return $this->create(null,'您没有权限删除该评论','400');
        }
        if($data){
            $data->delete();
            return $this->create($data,'删除成功','200');
        }else{
            return $this->create($data,'该评论不存在','400');
        }
    }
    
}
