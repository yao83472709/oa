<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/01 18:36
 * 功能：客户视图管理
 */
namespace App\Http\Controllers\View\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\User;
use App\Entity\Customers\Customers;
use App\Entity\Customers\CustomersDynamic;
use App\Entity\Customers\CustomerStatus;
use App\Entity\Projects\Projects;
use App\Entity\Customers\BusinessType;
use App\Entity\Customers\BusinessOrigin;
use App\Entity\Customers\Documentary;
use App\Entity\System\SysConfig;
use App\Entity\Area;

use Auth;


class CustomersController extends Controller
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
        $customers = Customers::where('company_id',$this->company_id)->latest()
                                ->where('lose',0)
                                ->orWhere('salesman_id',0)
                                ->paginate(12);
        if($customers) {
            foreach ($customers as $value) {
                $value->developer = User::find($value->developer_id, ['id', 'name' ,'head_portrait']);
                if($value->salesman_id) {
                    $value->salesman = User::find($value->salesman_id, ['id', 'name' ,'head_portrait']);
                }
                $value->business_type = BusinessType::find($value->type_id, ['name'])->name;
                $value->text_status = trans('list.customer.status.'.$value->lose);
                $value->created = $value->created_at->diffForHumans();
                $log = Documentary::where('company_id',$this->company_id)
                                  ->where('customer_id', $value->id)
                                  ->where('type', 2)
                                  ->where('make_id', Auth::user()->id)
                                  ->count();
                if($log) {
                    $value->isapply = 1;
                }
            }
        }
        return view($GLOBALS['cfg_style'].'.customer.index',compact('customers'));
    }

    /**
     * 我的客户
     */
    public function myCustomers()
    {
        $customers = Customers::where('company_id',$this->company_id)->latest()
                                ->where('developer_id',Auth::user()->id)
                                ->orWhere('salesman_id',Auth::user()->id)
                                ->paginate(12);

        foreach ($customers as $value) {
            $value->developer = User::find($value->developer_id, ['id', 'name' ,'head_portrait']);
            if($value->salesman_id) {
                $value->salesman = User::find($value->salesman_id, ['id', 'name' ,'head_portrait']);
            }
            $value->business_type = BusinessType::find($value->type_id, ['name'])->name;
            $value->text_status = trans('list.customer.status.'.$value->lose);
            $value->news = ($value->status_id ? CustomerStatus::find($value->status_id, ['name'])->name:'暂无动态');
            $value->created = $value->created_at->diffForHumans();
            $value->updated = $value->updated_at->diffForHumans();            
        }
        $customer_status = CustomerStatus::where('company_id',$this->company_id)->where('status',0)->orderBy('sort', 'asc')->lists('name', 'id');//客户状态        
        return view($GLOBALS['cfg_style'].'.customer.mycustomers',compact('customers','customer_status'));
    }

    /**
     * 新建客户
     */
    public function create()
    {
        $business_types = BusinessType::where('company_id',$this->company_id)->orderBy('sort', 'asc')->lists('name', 'id');//业务类型
        $business_orgins = BusinessOrigin::where('company_id',$this->company_id)->orderBy('sort', 'asc')->lists('name', 'id');//业务来源
        $provinces = Area::where('reid',0)->lists('name', 'id');//省份
        return view($GLOBALS['cfg_style'].'.customer.create',compact('business_types','business_orgins','provinces'));
    }

    /**
     * 查看客户详情
     */
    public function show($id)
    {
        $customer = Customers::findOrFail($id);
        $customer->developer = User::find($customer->developer_id, ['id', 'name' ,'head_portrait']);//开发者
        $customer->salesman = User::find($customer->salesman_id, ['id', 'name' ,'head_portrait']);//业务员
        $customer->business_type = BusinessType::find($customer->type_id, ['name'])->name;//业务类型
        $customer->origin = BusinessOrigin::find($customer->origin_id, ['name'])->name;//业务来源
        $customer->text_status = trans('list.customer.status.'.$customer->lose);
        if($customer->province) {
            $customer->province = Area::find($customer->province, ['name'])->name;//省份
            $customer->city = Area::find($customer->city, ['name'])->name;//市
            $customer->county = Area::find($customer->county, ['name'])->name;//区/县
        }
        return view($GLOBALS['cfg_style'].'.customer.show',compact('customer'));
    }

    /**
     * 查看我的客户详情
     */
    public function myCustomersShow($id)
    {
        $customer = Customers::findOrFail($id);
        $customer->developer = User::find($customer->developer_id, ['id', 'name' ,'head_portrait']);//开发者
        $customer->salesman = User::find($customer->salesman_id, ['id', 'name' ,'head_portrait']);//业务员
        $customer->business_type = BusinessType::find($customer->type_id, ['name'])->name;//业务类型
        $customer->origin = BusinessOrigin::find($customer->origin_id, ['name'])->name;//业务来源 
        $dynamics = CustomersDynamic::latest()->where('company_id',$customer->company_id)->where('customer_id',$id)->get();//客户动态
        if($dynamics) {
            foreach ($dynamics as $dynamic) {
                $dynamic->created = $dynamic->created_at->diffForHumans();
                $dynamic->status = CustomerStatus::find($dynamic->status_id, ['name'])->name;
                $dynamic->user = User::find($dynamic->user_id, ['id', 'name' ,'head_portrait']);//开发者
            } 
        }
        $projects = Projects::latest()->where('company_id',$customer->company_id)->where('customer_id',$id)->get();//客户动态
        $customer->text_status = trans('list.customer.status.'.$customer->lose);
        if($customer->province) {
            $customer->province = Area::find($customer->province, ['name'])->name;//省份
            $customer->city = Area::find($customer->city, ['name'])->name;//市
            $customer->county = Area::find($customer->county, ['name'])->name;//区/县
        }
        return view($GLOBALS['cfg_style'].'.customer.mycustomers_show',compact('customer','dynamics','projects'));
    }
    
    /**
     * 编辑客户信息
     */
    public function edit($id)
    {
        $customer = Customers::findOrFail($id);
        $business_types = BusinessType::where('company_id',$this->company_id)->orderBy('sort', 'asc')->lists('name', 'id');//业务类型
        $business_orgins = BusinessOrigin::where('company_id',$this->company_id)->orderBy('sort', 'asc')->lists('name', 'id');//业务来源
        $provinces = Area::where('reid',0)->lists('name', 'id');//省份
        return view($GLOBALS['cfg_style'].'.customer.edit' ,compact('customer','business_types','business_orgins','provinces'));
    }

}
