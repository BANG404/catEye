<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends BaseController
{
    //
    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $name = md5(microtime(true)) . '.' . $image->extension();
                $image->move('static/upload', $name);
                $path = '/static/upload/' . $name;
                $return_data = [
                    'filename' => $name,
                    'path' => $path
                ];
                $res = [
                    'code' => 1,
                    'msg' => '上传成功！',
                    'time' => time(),
                    'data' => $return_data
                ];
                return response()->json($res);
            }
            return $image->getErrorMessage();
        }
        return $this->create(null, '上传失败！', '400');
    }
}
