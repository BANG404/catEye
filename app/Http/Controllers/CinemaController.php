<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Http\Request;
use App\Models\Hall;
use App\Models\Session;

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
        //根据影院id查找影厅
        $hall=Hall::select('hall_id','name','cinema_id','capacity')->where('cinema_id',$id)->get();
        //根据影院id查询会话记录
        $session=Session::select('session_id','hall_id','movie_id','date','startTime','price','remain')->where('cinema_id',$id)->get();
        return $this->create(['cinema'=>$cinema,'hall'=>$hall,'session'=>$session],'查找成功','200');
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
