<?php
/*
|--------------------------------------------------------------------------
| 数据字段语言包
|--------------------------------------------------------------------------
*/
return [
    //以下是胥毅添加

        //项目账
        'project'=>[
            'type_project' => '项目总账列表',
            'type_project_show' => '项目账详情列表',
            'project_name' => '项目名称',
            'total_price' => '项目总额',
            'payment_ratio' => '付款比例',
            'price' => '已付款金额',
            'reprice' => '未付款金额',
            'salesman' => '业务员',
            'operation' => '操作',
            'create_project_title'=>'添加收款记录',
            'show_project_title'=>'收款记录',
            'form'=>[
                'projectName'=>'项目名称',
                'agreement_number'=>'合同编号',
                'total_price'=>'成交价',
                'payment_ratio'=>'付款比例',
                'price'=>'付款金额',
                'stage'=>'账期',
                'examine'=>'回款确认',
                'time'=>'到账时间',
                'examine_time'=>'操作时间',
                'examine_user'=>'操作员',
            ],
        ],
        //流水账
        'run'=>[
            'type_name'=>'流水账列表',
            'time'=>'创建时间',
            'date'=>'消费时间',
            'description'=>'摘要',
            'account_type'=>'收支种类',

            'in'=>'收入',
            'out'=>'支出',
            'inventory'=>'结存',
            'operation' => '操作',
            'form'=>[
                'select_default'=>'请选择',
                'runtype_name'=>'种类名称',
                'status'=>'收支类型',
                'account_sys_type'=>'支出种类',
                'status_in'=>'收入',
                'status_out'=>'支出',
                'money'=>'付款金额',
            ],
        ],
        //流水账类型
        'runtype'=>[
            'create_run_title'=>'创建流水账类型',
            'edit_run_title'=>'编辑流水账类型',
            'show_project_title'=>'显示流水账类型',
            'runtype_title' => '流水账类型列表',
            'name'=>'类型名称',
            'status'=>'类型',
            'operation' => '操作',
        ],
        //工资
        'salary'=>[
            'list'=>'工资列表',
            'month'=>'月份',
            'department'=>'部门',
            'name'=>'姓名',
            'basicSalary'=>'底薪',
            'integralSalary'=>'积分工资',
            'bonuslSalary'=>'提成工资',
            'safeDeduct'=>'社保扣除',
            'reward'=>'奖励',
            'deduct'=>'其他扣除',
            'totalSalary'=>'实发薪资',
            'operation' => '操作',
        ],
        //提成工资记录
        'bonus'=>[
            'type'=>'提成类型',
            'projectName'=>'项目名称',
            'price'=>'收款金额',
            'bonus'=>'提成比例',
            'salary'=>'提成薪资',
            'integral'=>'积分数量',
            'typeProject'=>'项目提成',
            'typeIntegral'=>'积分兑换',
        ],
        //薪资奖励处罚
        'salaryReward'=>[
            'money'=>'金额',
            'examine'=>'操作者',
            'content'=>'说明',
        ],
        //总账
        'account'=>[
            'month'=>'月份',
            'project'=>'项目账',
            'run'=>'流水账',
            'totalIn'=>'总收入',
            'dailyt'=>'日常开销',
            'office'=>'办公开销',
            'salary'=>'薪资开销',
            'cost'=>'成本开销',
            'taxation'=>'税务开销',
            'other'=>'其他开销',
            'totalOut'=>'总支出',
            'turnover'=>'营业额',
            'inventory'=>'结存',
            'operation' => '操作',
        ]

    //以上上胥毅添加


];
