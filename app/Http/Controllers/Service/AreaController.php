<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/4 0:36
 * 功能：地区数据管理
 */
namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entity\Area;

class AreaController extends Controller
{
    /**
     * 获取数据
     */
    public function getArea(Request $request)
    {
        $reid = $request->input('reid', '');
        $citys = Area::where('reid',$reid)->lists('name', 'id');
        //print_r($citys);die;
        return $citys;
    }

}
