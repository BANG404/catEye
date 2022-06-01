<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Session;
use App\Models\Cinema;
use App\Models\Hall;
use App\Models\Comments;

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
        return $this->create(User::select('user_id','name','email','headImg')->simplepaginate(10),'查找成功','200');
        
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

    //获取用户购票列表
    public function order(Request $request){
        $user= $request->session()->get('user');
        $id= $user['user_id'];
        $data=Ticket::select('ticket_id','ticket.seat',
        'user.name AS username',
        'user.headImg AS userheadimg',
        'session.date AS sessiondate',
        'session.startTime',
        'session.price AS price',
        'movie.name  AS moviename',
        'movie.type as movietype',
        'hall.name  AS hallname',
        'cinema.name  AS cinemaname' )->leftJoin('session','session.session_id','=','ticket.session_id')->leftJoin('movie','movie.movie_id','=','session.movie_id')->leftJoin('hall','hall.hall_id','=','session.hall_id')->leftJoin('cinema','cinema.cinema_id','=','hall.cinema_id')->leftJoin('user','user.user_id','=','ticket.user_id')->where('ticket.user_id','=',$id)->simplepaginate(10);
        // $data=Ticket::select('ticket_id','session_id','hall_id','seat')->where('user_id',$id)->paginate(10);
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

    public function delComment(Request $request, $id){
        //删除评论
        $data=Comments::find($id);
        //获取登录用户的id 
        $user=$request->session()->get('user');
        $id=$user['user_id'];

        //判断删除的评论是否是登录用户的
        if($data->user_id!=$id){
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
