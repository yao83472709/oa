<?php
/*
|--------------------------------------------------------------------------
| 跟单申请 列表页面
|--------------------------------------------------------------------------
*/
return [
    'page_title'       => '所有申请',
    'more'             => '查看',
    'refresh'          => '刷新',
    'search'           => '搜索',
    'action'           => '操作',
    'placeholder'      => '查找客户',
    'status'           =>[
                            '0' => '<span class="label label-warning">未审核</span>',
                            '1' => '<span class="label label-primary">已审核</span>',
                            '2' => '<span class="label label-danger">未通过</span>',
                        ],
    'no_data'          => '还没有任何跟单申请信息',
    'details'          => '客户详情',
    'ongoing'          => '进行中',
    'lost'             => '已丢单',
    'not_assigned'     => '等待分配',
];