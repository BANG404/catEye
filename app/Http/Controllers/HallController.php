<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Session;
use App\Models\Ticket;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HallController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取所有影厅
        $hall=Hall::select('hall_id','name','cinema_id','capacity')->get();
        return $this->create($hall,'查找成功','200');
        
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   
        if(!$request->hall_id){
            return $this->create(null,'请选择影厅','400');
        }
        if(!$request->session_id){
            return $this->create(null,'请选择会话','400');
        }
        $seesion_id=$request->session_id;
        $hall_id=$request->hall_id;
        //根据影厅id查找座位和影厅信息
        $hall=Hall::find($hall_id);
        $rows=$hall->rows;
        $cols=$hall->cols;
        $seats=[];
        for($i=0;$i<$rows;$i++){
            for($j=0;$j<$cols;$j++){
                $seats[$i][$j]['name']='第'.($i+1).'排第'.($j+1).'座';
                $seats[$i][$j]['status']=0;
            }
        }
        $ticket=Ticket::where('session_id',$seesion_id)->get();
        foreach($ticket as $k=>$v){
            $seat=$v->seat;
            $i=Str::before($seat,'排');
            $temp=Str::after($seat,'排');
            $j=Str::before($temp,'座');
            $i=intval($i)-1;
            $j=intval($j)-1;
            // dump($i); 
            $seats[$i][$j]['status']=1;
        }
        // $hallbody=Hall::find($id);
        // $hall=Hall::select('hall_id','name','cinema_id','capacity')->where('cinema_id',$id)->get();
        // //获取影厅相关信息
        // $cinemainfo=$hallbody->getcinema;
        $hall['seats']=$seats;
        return $this->create([$hall],'查找成功','200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hall $hall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hall $hall)
    {
        //
    }
}
