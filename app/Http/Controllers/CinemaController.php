<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Http\Request;
use App\Models\Hall;
use App\Models\Session;
use App\Models\Ticket;
use App\Models\Movie;

class CinemaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取所有电影院
        $cinema=Cinema::select('cinema_id','name','address')->get();
        return $this->create($cinema,'查找成功','200');
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
     * 查找影院的相关信息
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //根据影院id查找影厅
        $cinema=Cinema::find($id);
        //根据影院id查找厅
        $hall=Hall::select('hall_id','name','cinema_id','capacity')->where('cinema_id',$id)->get();
        //根据影院id查询会话记录
        $session=Session::select('session_id','hall_id','movie_id','date','startTime','price','remain')->where('cinema_id',$id)->get();
        return $this->create(['cinema'=>$cinema,'hall'=>$hall,'session'=>$session],'查找成功','200');
    }

    public function getCinemaMovie(Request $request){
        $cinema_id=$request->cinema_id;
        $movie_id=$request->movie_id;
        if(!$cinema_id){
            return $this->create(null,'请选择影院','400');
        }
        //判断电影是否过期
        $today=date('Y-m-d');
        $days=[];
        for($i=0;$i<7;$i++){
            $days[]=date('Y-m-d',strtotime("$today-$i day"));
        }
        if(!$movie_id){
            $movie_id=Session::select('movie_id')->where('cinema_id',$cinema_id)->first()->movie_id;
            if(!$movie_id){
                return $this->create(null,'该影院无电影','400');
            }
        }
        $session=Session::where('cinema_id',$cinema_id)->where('movie_id',$movie_id)->whereIn('date',$days)->get();
        if(count($session)==0){
            return $this->create(null,'该影院没有该电影的排期','400');
        }
        foreach ($session as $key => $value) {
            $session[$key]->hall=Hall::find($value->hall_id);
            $session[$key]->movie=Movie::find($value->movie_id);
            $session[$key]->cinema=Cinema::find($value->cinema_id);
        }
        return $this->create($session,'查找成功','200');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function edit(Cinema $cinema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cinema $cinema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cinema  $cinema
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cinema $cinema)
    {
        //
    }
}
