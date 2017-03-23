@extends( $httpView.'.layouts.master' )
@section('title', $httpTitle)
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
                        <h5>{{ trans('fields.account.type_project') }}</h5>

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
                                <th >{{ trans('fields.account.project_name') }}</th>
                                <th>{{ trans('fields.account.total_price') }}</th>
                                <th>{{ trans('fields.account.payment_ratio') }}</th>
                                <th>{{ trans('fields.account.price') }}</th>
                                <th>{{ trans('fields.account.reprice') }}</th>
                                <th data-hide="all">{{ trans('fields.account.salesman') }}</th>
                                <th>{{ trans('fields.account.operation') }}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>{{ $data->project_name }}</td>
                                    <td>{{ $data->total_price }}</td>
                                    <td>{{ $data->payment_ratio }}</td>
                                    <td>{{ $data->payment }}</td>
                                    <td>{{ $data->nopayment }}</td>
                                    <td>{{ $data->user_name }}</td>
                                    <td class="tooltip-demo">
                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('common.edit') }}" data-id="{{$data->id}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm show_btn" data-original-title="{{ trans('common.show') }}" data-id="{{$data->id}}">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="8">
                                    <ul class="pagination pull-right"></ul>
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
            $('.edit_btn').click(function() {
                var typeid = $(this).attr('data-id');
                layer.open({
                    type: 2,
                    title: "{{ trans('save.account.create_project_title') }}",
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['850px', '700px'],
                    offset: '50px',
                    shift: 2,
                    content: [ '/account/project/'+typeid+'/edit', 'no'] //iframe的url，no代表不显示滚动条
                });
            });
            //详情页面
            $('.show_btn').click(function() {
                var typeid = $(this).attr('data-id');
                layer.open({
                    type: 2,
                    title: "{{ trans('save.account.show_project_title') }}",
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['850px', '500px'],
                    offset: '50px',
                    shift: 2,
                    content: [ '/account/project/'+typeid, 'no'] //iframe的url，no代表不显示滚动条
                });
            });


        });

    </script>
@endsection
