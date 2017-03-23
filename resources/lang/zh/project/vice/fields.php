<?php
/*
|--------------------------------------------------------------------------
| 项目 字段名称
|--------------------------------------------------------------------------
*/
return [
    'leader'           => '组长',
    'development_cycle'=> '开发周期',
    'actual_cycle'     => '实际周期',
    'is_examine'       => '是否验收 ',
    'is_examine_val'   => [
                            '0' => '未验收',
                            '1' => '已验收',
                          ],
    'examine'          => '验收时间',
    'is_start'         => '项目启动',
    'is_start_val'     => '<span class="label label-primary">已启动</span>',
    'start'            => '开始时间',
    'end'              => '结束时间',
    'member'           => '组员',
    'file'             => '文件',                        
    'is_finish'        => '是否已完成',
    'is_finish_val'    => [
                            '0' => '<span class="label label-warning">进行中</span>',
                            '1' => '<span class="label label-primary"><i class="fa fa-check"></i> 已完成</span>',
                          ],
    'cis_finish_val'    => [
                            '0' => '进行中',
                            '1' => '已完成',
                          ],
    'grade'            => '任务等级', 
    'description'      => '备注',
    'updated_at'       => '最后更新',
    'submit'           => '保存内容',
];