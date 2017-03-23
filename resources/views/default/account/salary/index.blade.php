@extends($cfg_style.'.layouts.master')
@section('title',$cfg_company.'_'.$cfg_webname)
@section('self_head')
    <link href="/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
@endsection
@section('content')
    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ trans('account\fields.salary.list') }}</h5>

                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="refresh-link" >
                                <i class="fa fa-refresh"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="12">
                            <thead>
                            <tr>
                                <th >{{ trans('account\fields.salary.month')}}</th>
                                <th >{{ trans('account\fields.salary.department') }}</th>
                                <th >{{ trans('account\fields.salary.name') }}</th>
                                <th >{{ trans('account\fields.salary.basicSalary') }}</th>
                                <th >{{ trans('account\fields.salary.integralSalary') }}</th>
                                <th >{{ trans('account\fields.salary.safeDeduct') }}</th>
                                <th >{{ trans('account\fields.salary.reward') }}</th>
                                <th >{{ trans('account\fields.salary.deduct') }}</th>
                                <th >{{ trans('account\fields.salary.totalSalary') }}</th>
                                <th >{{ trans('account\fields.salary.operation') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{ date('Y-m',strtotime($data->month))}} </td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->department }}</td>
                                    <td>@if(!empty($data->basic_salary)){{ trans('account\common.money_sign') }}{{ $data->basic_salary }}@endif</td>
                                    <td>@if(!empty($data->integral_salary)){{ trans('account\common.money_sign') }}{{ $data->integral_salary }}@endif</td>
                                    <td>@if(!empty($data->safe_deduct)){{ trans('account\common.money_sign') }}{{ $data->safe_deduct }}@endif</td>
                                    <td>@if(!empty($data->reward)){{ trans('account\common.money_sign') }}{{ $data->reward }}@endif</td>
                                    <td>@if(!empty($data->deduct)){{ trans('account\common.money_sign') }}{{ $data->deduct }}@endif</td>
                                    <td>@if(!empty($data->total_salary)){{ trans('account\common.money_sign') }}{{ $data->total_salary }}@endif</td>
                                    <td class="tooltip-demo">
                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm show_btn" data-original-title="{{ trans('account\common.show') }}" data-id="{{$data->user_id}}" data-month="{{date('Y-m',strtotime($data->month))}}">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="10">
                                    {!! $datas->render() !!}
                                </td>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection


@section( 'self_js')

    <script src="/js/content.js?v=1.0.0"></script>
    <!-- Bootstrap table -->
    <script src="/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
    <script src="/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
    <!-- Peity -->
    <script src="/js/demo/bootstrap-table-demo.js"></script>



    <script>
        $(document).ready(function() {
            //编辑页面
            $('.show_btn').click(function() {
                var userid = $(this).attr('data-id');
                var month = $(this).attr('data-month');
                layer.open({
                    type: 2,
                    title: "{{ trans('account\save.salary.show') }}",
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['850px', '700px'],
                    offset: '50px',
                    shift: 2,
                    content: [ '/account/salary/'+userid+'?month='+month] //iframe的url，no代表不显示滚动条
                });
            });


        });

    </script>
@endsection
