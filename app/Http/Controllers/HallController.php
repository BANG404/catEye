<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Cinema;
use Illuminate\Http\Request;

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
    public function show($id)
    {
        //根据影视id查找影厅
        $hallbody=Hall::find($id);
        $hall=Hall::select('hall_id','name','cinema_id','capacity')->where('cinema_id',$id)->get();
        //获取影厅相关信息
        $cinemainfo=$hallbody->getcinema;
        return $this->create(['cinema'=>$cinemainfo,'hall'=>$cinemainfo],'查找成功','200');
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
