<?php
/*
|--------------------------------------------------------------------------
| 添加数据语言包
|--------------------------------------------------------------------------
*/
return [
    'common'=>[
        'sys_error'=> '非法操作',
        'not_login'=> '请先登录',
        'add_success' => '添加成功',
        'add_failed'=> '添加失败',
        'update_success'=> '更新成功',
        'update_failed'=> '更新失败',
        'del_success'=> '删除成功',
        'del_failed'=> '删除失败',
    ],
    'form'=>[
        'submit'=> '保存内容',
    ],

    'project'=>[
        'create_project_title'=>'添加收款项',
        'show_project_title'=>'收款项详情',
        'time'=>'时间不能为空',
        'time_type'=>'时间格式正确',
        'examine'=>'请确定已经回款',
    ],
    'run'=>[
        'create_run_title'=>'添加流水账',
        'edit_run_title'=>'编辑流水账',
        'validate'=>[
            'name_required'=>'种类名称不能为空',
            'name_min'=>'请选择收支种类',
            'status'=>'请选择类型',
            'money_required'=>'请填写金额',
            'money_number'=>'金额格式不正确',
            'date'=>'请填写时间',
            'date_type'=>'时间格式不正确',
        ]
    ],
    'runtype'=>[
        'create_runtype_title'=>'添加流水账类型',
        'show_runtype_title'=>'流水账类型详情',
        'validate'=>[
            'name_required'=>'类型名称不能为空',
            'min_length'=>'类型名称最小长度为2位',
            'status'=>'请选择类型',
        ]
    ],
    'msg'=>[
        'nonull'=>'不能为空！'
    ],
    'salary'=>[
        'show'=>'工资详情',
    ]




];

