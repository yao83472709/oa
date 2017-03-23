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
                        <h5>{{ trans('account\fields.runtype.runtype_title') }}</h5>

                        <div class="ibox-tools">
                            <a class="create-link">
                                <i class="fa fa-plus-square"></i>
                            </a>
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
                                <th >{{ trans('account\fields.runtype.name') }}</th>
                                <th>{{ trans('account\fields.runtype.status') }}</th>
                                <th>{{ trans('account\fields.runtype.operation') }}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{ $data->name }}</td>
                                    @if($data->status ==1)
                                        <td>收入</td>
                                    @else
                                        <td> {{ $data->sysName }}</td>
                                    @endif
                                    <td class="tooltip-demo">
                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('account\common.edit') }}" data-id="{{$data->id}}" data-company="{{$data->company_id}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm del_btn" data-original-title="{{ trans('account\common.delete') }}" data-id="{{$data->id}}" data-company="{{$data->company_id}}">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3">
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
            //添加页面
            $('.create-link').click(function() {
                layer.open({
                    type: 2,
                    title: "{{ trans('account\fields.runtype.create_run_title') }}",
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['850px', '700px'],
                    offset: '50px',
                    shift: 2,
                    content: [ '/account/runtype/create', 'no'] //iframe的url，no代表不显示滚动条
                });
            });
            //编辑页面
            $('.edit_btn').click(function() {
                var typeid = $(this).attr('data-id');
                layer.open({
                    type: 2,
                    title: "{{ trans('account\fields.runtype.edit_run_title') }}",
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['850px', '700px'],
                    offset: '50px',
                    shift: 2,
                    content: [ '/account/runtype/'+typeid+'/edit', 'no'] //iframe的url，no代表不显示滚动条
                });
            });
            //删除
            $('.del_btn').click(function () {
                var typeid = $(this).attr('data-id');
                var companyid = $(this).attr('data-company');
                layer.confirm("{{ trans('account\common.del_confirm') }}", {
                    offset: '25%',
                    time: 20000, //20s后自动关闭
                    btn: ["{{ trans('account\common.yes') }}", "{{ trans('account\common.no') }}"]
                },function () {
                    $.ajax({
                        type: "POST",
                        url:  "{{ url('/account/runtype/destroy') }}",
                        dataType: 'json',
                        cache: false,
                        data: {'id':typeid,'companyid':companyid},
                        success: function(data) {
                            layer.msg(data.message, {icon: 1});
                            setTimeout(function () {
                                location.reload();
                            },1000);
                        },
                        error: function(xhr) {
                            $.each(xhr.responseJSON,function(n,value) {
                                $.each(value,function(n,data){
                                    layer.msg(data.message, {icon: data.msgnum});
                                });
                            });
                        }
                    });
                },function (index) {
                    layer.close(index);
                });
            })


        });

    </script>
@endsection
