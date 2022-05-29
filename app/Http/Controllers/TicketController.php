<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Session;
use App\Models\Cinema;
use App\Models\Hall;
use Illuminate\Http\Request;

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
        return $this->create($ticket,'购买成功','200');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
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
