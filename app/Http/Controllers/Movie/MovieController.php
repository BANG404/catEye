<?php

namespace App\Http\Controllers\Movie;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Comments;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;

class MovieController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->create(Movie::select('movie_id','name','staring','detail','duration','type','score','picture')->simplepaginate(10),'查找成功','200');
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
            'name'=>'required|max:255|unique:movie',
            'staring'=>'required|max:255',
            'detail'=>'required|max:255',
            'duration'=>'required|max:255',
            'type'=>'required|max:255',
            'picture'=>'required|max:255',
        ]);
        if($validator->fails()){
            return $this->create([],$validator->errors()->first(),'400');
        }
        //数据入库
        $addData=Movie::create($data);
        // $movie=new Movie;
        // $movie->name=$data['name'];
        // $movie->staring=$data['staring'];
        // $movie->detail=$data['detail'];
        // $movie->duration=$data['duration'];
        // $movie->type=$data['type'];
        // $movie->picture=$data['picture'];
        // $movie->boxOffice=$data['boxOffice'];
        // $movie->releaseDate=$data['releaseDate'];
        // $movie->boxOfficeUnit=$data['boxOfficeUnit'];
        // $movie->foreignName=$data['foreignName'];
        // $movie->releasePoint=$data['releasePoint'];
        // $movie->save();
        if($addData){
            return $this->create($addData,'添加成功','200');
        }else{
            return $this->create([],'添加失败','400');
        }
    }

    /**
     * Display the specified resource.
     * 获取详细信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // if(!is_numeric($id)){
        //     return $this->create([], '参数错误，请输入数字', '400');
        // }
        //
        $data=Movie::find($id);
        //获取电影评论
        $comments=Comments::where('movie_id',$id)->get();
        //获取播放当前电影的电影院
        $cinemas=DB::select('SELECT cinema.cinema_id , cinema.`name` AS cinemaname,cinema.address AS cinemaaddress FROM `session` LEFT JOIN cinema ON `session`.cinema_id =cinema.cinema_id WHERE `session`.movie_id=?', [$id]);
        if($data){
            return $this->create(['movieInfo'=>$data,'cinemas'=>$cinemas,'Comments'=>$comments],'查找成功','200');
        }else{ 
            return $this->create(null, '未查找到该电影', '400');
        }
        // return $this->create($data,'成功',200);
    }

    /**
     * Update the specified resource in storage.
     * 更新电影信息
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data=$request->all();
        //数据验证
        // $validator=\Validator::make($data,[
        //     'name'=>'required|max:255',
        //     'staring'=>'required|max:255',
        //     'detail'=>'required|max:255',
        //     'duration'=>'required|max:255',
        //     'type'=>'required|max:255',
        //     'picture'=>'required|max:255',
        // ]);
        // if($validator->fails()){
        //     return $this->create([],$validator->errors()->first(),'400');
        // }
        //数据入库
        $addData=Movie::where('movie_id',$id)->update($data);
        if($addData){
            return $this->create($addData,'更新成功','200');
        }else{
            return $this->create([],'更新失败','400');
        }

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
        $data=Movie::find($id);
        if($data){
            $data->delete();
            return $this->create(null,'删除成功','200');
        }else{
            return $this->create(null,'该电影不存在','400');
        }
    }
}
