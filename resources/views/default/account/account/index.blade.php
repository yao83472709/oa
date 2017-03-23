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
                            <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm create_btn" data-original-title="{{ trans('accout\common.create') }}">
                                <i class="fa fa-pencil"></i>
                            </button>
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
                                <th >{{ trans('account\fields.account.month')}}</th>
                                <th >{{ trans('account\fields.account.project') }}</th>
                                <th >{{ trans('account\fields.account.run') }}</th>
                                <th >{{ trans('account\fields.account.totalIn') }}</th>
                                <th >{{ trans('account\fields.account.dailyt') }}</th>
                                <th >{{ trans('account\fields.account.office') }}</th>
                                <th >{{ trans('account\fields.account.salary') }}</th>
                                <th >{{ trans('account\fields.account.cost') }}</th>
                                <th >{{ trans('account\fields.account.taxation') }}</th>
                                <th >{{ trans('account\fields.account.other') }}</th>
                                <th >{{ trans('account\fields.account.totalOut') }}</th>
                                <th >{{ trans('account\fields.account.turnover') }}</th>
                                <th >{{ trans('account\fields.account.inventory') }}</th>
                               {{-- <th >{{ trans('account\fields.account.operation') }}</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{ date('Y-m',strtotime($data->month))}} </td>
                                    <td>@if(!empty($data->project_account)){{ trans('account\common.money_sign') }}{{ $data->project_account }}@endif </td>
                                    <td>@if(!empty($data->run_account)){{ trans('account\common.money_sign') }}{{ $data->run_account }}@endif</td>
                                    <td>@if(!empty($data->total_in)){{ trans('account\common.money_sign') }}{{ $data->total_in }}@endif</td>
                                    <td>@if(!empty($data->daily_account)){{ trans('account\common.money_sign') }}{{ $data->daily_account }}@endif</td>
                                    <td>@if(!empty($data->office_account)){{ trans('account\common.money_sign') }}{{ $data->office_account }}@endif</td>
                                    <td>@if(!empty($data->salary_account)){{ trans('account\common.money_sign') }}{{ $data->salary_account }}@endif</td>
                                    <td>@if(!empty($data->cost_account)){{ trans('account\common.money_sign') }}{{ $data->cost_account }}@endif</td>
                                    <td>@if(!empty($data->taxation_account)){{ trans('account\common.money_sign') }}{{ $data->taxation_account }}@endif</td>
                                    <td>@if(!empty($data->other_account)){{ trans('account\common.money_sign') }}{{ $data->other_account }}@endif</td>
                                    <td>@if(!empty($data->total_out)){{ trans('account\common.money_sign') }}{{ $data->total_out }}@endif</td>
                                    <td>@if(!empty($data->turnover)){{ trans('account\common.money_sign') }}{{ $data->turnover }}@endif</td>
                                    <td>@if(!empty($data->inventory)){{ trans('account\common.money_sign') }}{{ $data->inventory }}@endif</td>
                                    {{--<td class="tooltip-demo">
                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm show_btn" data-original-title="{{ trans('account\common.show') }}"  data-id="{{$data->id}}" >
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>--}}
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="13">
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
            //详情页面
            $('.create_btn').click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/account/account/create') }}",
                    dataType: 'json',
                    cache: false,
                    data: '',
                    success: function(data) {
                        layer.msg(data.message,{icon:data.msgnum});
                        if(data.state==1){
                            parent.location.reload(); // 父页面刷新
                            setTimeout(function () {
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.layer.close(index); //再执行关闭
                            },6000);
                        }
                    },
                    error: function(xhr) {
                        $.each(xhr.responseJSON,function(n,value) {
                            $.each(value,function(n,data){
                                layer.msg(data.message, {icon: data.msgnum});
                            });
                        });
                    }
                });
            });

            //详情页面
            $('.show_btn').click(function() {
                var id = $(this).attr('data-id');
                layer.open({
                    type: 2,
                    title: "{{ trans('account\save.salary.show') }}",
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['850px', '700px'],
                    offset: '50px',
                    shift: 2,
                   //iframe的url，no代表不显示滚动条
                    content: [ '/account/'+id]
                });
            });


        });

    </script>
@endsection
