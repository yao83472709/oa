@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
    <link href="/css/plugins/footable/footable.core.css" rel="stylesheet">
@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                @if($marks->count())
                    <div class="ibox-title">
                        <h5>{{ trans('mark/list.page_title') }}</h5>
                        <div class="ibox-tools">
                            <a class="create-link">
                                <i class="fa fa-plus-square"></i>
                            </a>
                            <a class="refresh-link" >
                                <i class="fa fa-refresh"></i>
                            </a>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="12">
                            <thead>
                            <tr>
                                <th data-toggle="true">{{ trans('mark/fields.name') }}</th>
                                <th>{{ trans('mark/fields.status') }}</th>
                                <th>{{ trans('mark/fields.bonus') }}</th>
                                <th data-hide="all">{{ trans('mark/fields.description') }}</th>
                                <th data-hide="all">{{ trans('mark/fields.created_at') }}</th>
                                <th>{{ trans('common.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($marks as $mark)
                            <tr>
                                <td>{{$mark->name}}</td>
                                <td>{!! $mark->status !!}</td>
                                <td>{{$mark->bonus}}</td>
                                <td>{{$mark->description}}</td>
                                <td>{{$mark->created_at}}</td>
                                <td class="tooltip-demo">
                                    <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('common.edit') }}" data-id="{{$mark->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm del_btn" data-original-title="{{ trans('common.delete') }}" data-id="{{$mark->id}}">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="8">
                                    <ul class="pagination pull-right "></ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="middle-box text-center animated fadeInRightBig">
                        <h3 class="font-bold">{{ trans('mark/list.no_data') }}</h3>
                        <div class="error-desc">
                            {{ trans('common.no_data_tip') }}
                            <br><a class="btn btn-primary m-t create-btn" >{{ trans('mark/list.create') }}</a>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

@section('self_js')
<!-- 自定义js -->
<script src="/js/plugins/footable/footable.all.min.js"></script>
<script src="/js/content.js?v=1.0.0"></script>
<script>
$(document).ready(function() {
    $('.footable').footable();

    $('.create-link,.create-btn').click(function () {
         layer.open({
          type: 2,
          title: "{{ trans('mark/save.create_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '520px'],
          offset: '12%',
          shift: 2,
          content: ["{{ url('marks/create') }}", 'no'], //iframe的url，no代表不显示滚动条
        });
    })
    
    $('.edit_btn').click(function() {
        var did = $(this).attr('data-id')
        layer.open({
          type: 2,
          title: "{{ trans('mark/save.edit_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '520px'],
          offset: '12%',
          shift: 2,
          content: ['marks/'+did+'/edit', 'no'], //iframe的url，no代表不显示滚动条
        });
    })

    $('.del_btn').click(function () {
          var did = $(this).attr('data-id')
          layer.confirm("{{ trans('common.del_confirm') }}", {
            offset: '25%',
            time: 20000, //20s后自动关闭
            btn: ["{{ trans('common.yes') }}", "{{ trans('common.no') }}"]
          },function () {
              $.ajax({
                  type: "POST",
                  url: "{{ url('marks/destroy') }}",
                  dataType: 'json',
                  cache: false,
                  data: {'id':did, _token:"{{ csrf_token() }}"},
                  success: function(data) {            
                      if(data.status == 0) {
                          layer.msg(data.message, {icon: 1});
                          setTimeout(function () {
                              location.reload(); // 父页面刷新
                          },1000);
                      }else{
                          layer.msg(data.message, {icon: 7});
                          return false
                      }
                  },
                  error: function(xhr) {
                     $.each(xhr.responseJSON,function(n,value) {
                            layer.msg(value+'', {icon: 7});
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

