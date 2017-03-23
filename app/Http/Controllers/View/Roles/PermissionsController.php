<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/13 17:28
 * 功能：权限数据管理
 */
namespace App\Http\Controllers\View\Roles;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\System\SysConfig;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\Entity\Role\PermissionRole;

use App\Entity\User;
use Auth;

class PermissionsController extends Controller
{
    private $company_id = null;

    public function __construct()
    {        
        $this->company_id = Auth::user()->company_id;
        if($this->company_id) {
           //获取配置信息
           $SysConfig = new SysConfig;
           $SysConfig->getConfigs($this->company_id);
           view()->share('cfg_style', $GLOBALS['cfg_style']);
           view()->share('cfg_company', $GLOBALS['cfg_company']);
        }
    }

    public function index()
    {

    }

    /**
     * 分配权限
     */
    public function Distribution($id)
    {
        $permissions = '';
        $self = PermissionRole::where('role_id',$id)->lists('permission_id')->toArray();
        $first = Permission::where('status',0)->where('parent_id',0)->where('level',1)->get();//一级
        foreach ($first as $k) {
            $second = Permission::where('status',0)->where('parent_id',$k->id)->where('level',2)->get();//二级
            $second_permissions = '';
            if($second) {
                $second_permissions .= '<div class="col-sm-11"><div class="form-group">';
                foreach ($second as $j) {
                    $third = Permission::where('status',0)->where('parent_id',$j->id)->where('level',3)->get();//三级
                    $third_permissions = '';
                    if($third) {
                        $third_permissions .= '<div class="col-sm-8"><div class="form-group">';
                        foreach ($third as $v) {
                             $ischeck = in_array($v->id, $self) ? 'checked="checked"' : '';
                             $third_permissions .= '<label class="checkbox-inline i-checks col-sm-3">
                                              <input type="checkbox" '.$ischeck.' name="prmission[]" value="'.$v->id.'">'.$v->name.'
                                             </label>';
                        }
                        $third_permissions .= '</div></div>';
                    }
                    $ischeck = in_array($j->id, $self) ? 'checked="checked"' : '';
                    $second_permissions .= '<label class="checkbox-inline i-checks col-sm-3 control-label">
                                              <input type="checkbox" '.$ischeck.' name="prmission[]" value="'.$j->id.'">'.$j->name.'
                                            </label>'.$third_permissions;
                }
                $second_permissions .= '</div></div>';
            }
            $permissions .= ' <div class="form-group">
                                <label class="checkbox-inline i-checks col-sm-3 control-label">
                                <input type="checkbox" '.$ischeck.' name="prmission[]" value="'.$k->id.'">'.$k->name.'</label>'
                              .$second_permissions.
                            '</div><div class="hr-line-dashed"></div>';

        }
        return view($GLOBALS['cfg_style'].'.roles.permissions.index',compact('permissions','id'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }
}
