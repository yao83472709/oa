<?php
/*
|--------------------------------------------------------------------------
| 项目任务 字段名称
|--------------------------------------------------------------------------
*/
return [
    'name'             => '任务名称',    
    'grade'            => '任务等级',
    'grade_val'        => '<span class="label label-warning">无</span>',
    'make_id'        => '指派人',
    'integral'         => '积分奖励',
    'actual_integral'  => '实际获取积分',
    'status_val'       => [
                            '0' => '<span class="label label-primary">正常</span>',
                            '1' => '<span class="label label-warning">已转出</span>',
                          ],
    'created_at'       => '分配时间',
    'finish_time'      => '完成时间',
    'file'             => '文件资料',
    'file_val'         => '<span class="label label-warning">无</span>',
    'description'      => '备注',

];