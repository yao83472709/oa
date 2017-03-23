<?php
/*
|--------------------------------------------------------------------------
| 项目 字段名称
|--------------------------------------------------------------------------
*/
return [
    'number'           => '编号',
    'name'             => '项目名称',
    'departments'      => '参与部门',
    'company'          => '企业名称',
    'type'             => '业务类型',
    'salesman'         => '业务员',
    'status'           => '当前进度',
    'start'            => '开始时间',
    'end'              => '结束时间',
    'development_cycle'=> '开发周期',
    'deal_price'       => '成交总价',
    'bonus'            => '项目提成比例',
    'is_invoice'       => '是否开发票',
    'is_invoice_val'   => [
                            '0' => '不开',
                            '1' => '开',
                          ],
    'is_record'        => '是否已备案',
    'is_record_val'    => [
                            '0' => '<span class="label label-warning">未备案</span>',
                            '1' => '<span class="label label-primary"><i class="fa fa-check"></i> 已备案</span>',
                          ],
    'cis_record_val'    => [
                            '0' => '未备案',
                            '1' => '已备案',
                          ],
    'payment_ratio'    => '付款比例',                          
    'is_finish'        => '是否已完成',
    'is_finish_val'    => [
                            '0' => '<span class="label label-warning">进行中</span>',
                            '1' => '<span class="label label-primary"><i class="fa fa-check"></i> 已完成</span>',
                          ],
    'cis_finish_val'    => [
                            '0' => '进行中',
                            '1' => '已完成',
                          ],    
    'record_file'      => '备案资料',
    'relevant_file'    => '开发资料',
    'description'      => '项目描述',
    'created_at'       => '创建于',
    'updated_at'       => '最后更新',
    'submit'           => '保存内容',
];