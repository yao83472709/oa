@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')

@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ trans('collection.list_title') }}</h5>
                        <div class="ibox-tools">
                            <a class="notice-member" >
                                <i class="fa fa-user"></i>
                            </a>
                            <a class="refresh-link" >
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                    @if(count($demands))
                        <div class="clients-list">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th data-toggle="true">{{ trans('collection.title') }}</th>
                                                    <th>{{ trans('collection.price') }}</th>
                                                    <th>{{ trans('collection.partake') }}</th>
                                                    <th>{{ trans('common.action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($demands as $demand)
                                                    <tr>
                                                    	<td>{{ $demand->title }}</td>                                                   
                                                        <td>{{ $demand->price }}</td>
                                                        <td>{{ $demand->partake }}</td>                     
                                                        <td class="tooltip-demo">
                                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm more_btn" data-original-title="{{ trans('collection.details') }}" data-id="{{ $demand->link }}" >
                                                                <i class="fa fa-share-square-o"></i>
                                                            </button>                                                
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="12" class="footable-visible">
                                                            {!! $demands->render() !!}
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="middle-box text-center animated fadeInRightBig">
                            <h3 class="font-bold">{{ trans('collection.no_data') }}</h3>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

@section('self_js')
<script src="/js/content.js?v=1.0.0"></script>
<script>
$(function () {
    $('.notice-member').click(function () {
        layer.open({
            type: 2,
            title: "{{ trans('collection.email_users') }}",
            shadeClose: true,
            shade: false,
            maxmin: true, //开启最大化最小化按钮
            area: ['850px', '650px'],
            offset: '8%',
            shift: 2,
            content: ["{{ url('bajie/notice',$type) }}"],//iframe的url，no代表不显示滚动条
        });
    })
    /*查看详情*/
    $('.more_btn').click(function () {
        window.open($(this).attr('data-id'))
    })
});
</script>
@endsection


