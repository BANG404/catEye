<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Session;
use App\Models\Cinema;
use App\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //分页查询获取所有电影票
        $ticket=Ticket::select('ticket_id','session_id','user_id','price','remain')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //数据验证
        $validator=\Validator::make($request->all(),[
            'session_id'=>'required',
            'hall_id'=>'required',
            'seat'=>'required',
        ]);
        if($validator->fails()){
            return $this->create(null,'数据验证失败',400);
        }
        //验证影厅是否存在
        $hall=Hall::find($request->hall_id);
        if(!$hall){
            return $this->create(null,'该影厅不存在','400');
        }
        //验证会话是否存在
        $session=Session::find($request->session_id);
        if(!$session){
            return $this->create(null,'该会话不存在','400');
        }
        //判断会话和影厅是否匹配
        if($session->hall_id!=$request->hall_id){
            return $this->create(null,'该会话和影厅不匹配','400');
        }
        //购买电影票
        $user= $request->session()->get('user');
        $ticket=new Ticket();
        $ticket->user_id=$user['user_id'];
        $ticket->session_id=$request->session_id;
        $ticket->hall_id=$request->hall_id;
        $ticket->seat=$request->seat;
        $ticket->save();
        //修改剩余票数
        $session->remain=$session->remain-1;
        $session->save();
        return $this->create($ticket,'购买成功','200');

    }

    /**
     * Display the specified resource.
     * 查看票的详细信息
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //判断票是否存在
        $ticket=Ticket::find($id);
        if(!$ticket){
            return $this->create(null,'该票不存在','400');
        }
        //判断票是否属于当前用户
        $user= $request->session()->get('user');
        if($ticket->user_id!=$user['user_id']){
            return $this->create(null,'该票不属于当前用户','400');
        }
        //获取票的详细信息
        $data=DB::select("SELECT
        ticket.ticket_id,
        ticket.seat,
        `user`.`name` AS username,
        `user`.headImg AS userheadimg,
        `session`.date AS sessiondate,
        `session`.startTime,
        `session`.price AS price,
        movie.`name` AS moviename,
        movie.type as movietype,
        hall.`name` AS hallname,
        cinema.`name` AS cinemaname 
        FROM
        ticket
        LEFT JOIN `user` ON ticket.user_id = USER.user_id
        LEFT JOIN hall ON ticket.hall_id = hall.hall_id
        LEFT JOIN cinema ON hall.cinema_id = cinema.cinema_id
        LEFT JOIN `session` ON ticket.session_id = `session`.session_id
        LEFT JOIN movie ON `session`.movie_id = movie.movie_id
        WHERE ticket_id =:id",['id'=>$id]);
        return $this->create($data,'查询成功','200');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
