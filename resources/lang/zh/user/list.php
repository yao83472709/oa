<?php
/*
|--------------------------------------------------------------------------
| 职位/权限 列表页面
|--------------------------------------------------------------------------
*/
return [
    'placeholder'      => '查找员工',
    'page_title'       => '所有员工',
    'create'           => '创建新员工',
    'edit'             => '编辑新员工',
    'details'          => '员工详情',
    'status'           =>[
                            '0' => '<span class="label label-primary">在职</span>',
                            '1' => '<span class="label label-danger">离职</span>',
                            '2' => '<span class="label label-warning">冻结</span>',
                         ],
    'not_assigned'     => '等待分配',
    'placeholder'      => '查找员工',
    'no_data'          => '还没有任何员工信息',
    'documentary'      => '申请跟单',
    'confirm_documentary'=> '确定要跟单吗？',
    'already'          => '已申请跟单',

];