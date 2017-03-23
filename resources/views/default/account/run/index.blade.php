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
                        <h5>{{ trans('account\fields.run.type_name') }}</h5>

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
                                <th >{{ trans('account\fields.run.time') }}</th>
                                <th >{{ trans('account\fields.run.date') }}</th>
                                <th>{{ trans('account\fields.run.description') }}</th>
                                <th>{{ trans('account\fields.run.account_type') }}</th>
                                <th>{{ trans('account\fields.run.in') }}</th>
                                <th>{{ trans('account\fields.run.out') }}</th>
                                <th>{{ trans('account\fields.run.inventory') }}</th>
                               {{-- <th>{{ trans('account\fields.run.operation') }}</th>--}}

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{ $data->updated_at }}</td>
                                    <td>{{ $data->date }}</td>
                                    <td>{{ $data->description }}</td>

                                    @if(!empty($data->name))
                                        <td>{{ $data->name }}</td>
                                    @else
                                        <td>{{ $data->sysName }}</td>
                                    @endif
                                    @if($data->type==1)
                                        <td>@if(!empty($data->money)){{ trans('account\common.money_sign') }}{{ $data->money }}@endif </td>
                                        <td></td>
                                    @elseif($data->type==2)
                                        <td></td>
                                        <td>@if(!empty($data->money)){{ trans('account\common.money_sign') }}{{ $data->money }}@endif </td>
                                    @endif
                                    <td>@if(!empty($data->inventory)){{ trans('account\common.money_sign') }}{{ $data->inventory }}@endif </td>
                                   {{-- <td class="tooltip-demo">
                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('account\common.edit') }}" data-id="{{$data->id}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7">
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

            $('.create_btn').click(function() {
                layer.open({
                    type: 2,
                    title: "{{ trans('account\save.run.create_run_title') }}",
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['850px', '750px'],
                    offset: '50px',
                    shift: 2,
                    content: [ '/account/run/create',] //iframe的url，no代表不显示滚动条
                });
            });
           //编辑页面
            //编辑页面
            $('.edit_btn').click(function() {
                var typeid = $(this).attr('data-id');
                layer.open({
                    type: 2,
                    title: "{{ trans('account\save.project.create_project_title') }}",
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['850px', '700px'],
                    offset: '50px',
                    shift: 2,
                    content: [ '/account/run/'+typeid+'/edit',] //iframe的url，no代表不显示滚动条
                });
            });


        });

    </script>
@endsection
