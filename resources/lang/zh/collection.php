<?php
/*
|--------------------------------------------------------------------------
| 猪八戒采集
|--------------------------------------------------------------------------
*/
return [
    /*页面*/
    'list_title'      => '最新需求',
    'details'         => '查看详情',
    'email_users'     => '邮件通知用户',

    /*字段*/
    'title'           => "标题",
    'link'            => "链接",
    'price'           => "价格",
    'partake'         => "竞标详情",

    /*提示*/
    'no_data'         => '还没有新的需求',
    'is_email'        => [
                            '0'=>'关闭',
                            '1'=>'开启',
                         ],
    'demand'          => [
                            '0'=>'网站建设',
                            '1'=>'品牌设计',
                         ],
    'success'         => '获取成功',
    'email_title'     => ":count个:demand需求，来自猪八戒",
];