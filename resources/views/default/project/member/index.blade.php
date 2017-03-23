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
                @if($customerstatus)
                    <div class="ibox-title">
                        <h5>{{ trans('project/projectstatus/list.page_title') }}</h5>
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
                                <th data-toggle="true">{{ trans('project/projectstatus/fields.name') }}</th>
                                <th>{{ trans('project/projectstatus/fields.status') }}</th>
                                <th data-hide="all">{{ trans('project/projectstatus/fields.description') }}</th>
                                <th data-hide="all">{{ trans('project/projectstatus/fields.created_at') }}</th>
                                <th>{{ trans('project/projectstatus/list.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($customerstatus as $status)
                            <tr>
                                <td>{{$status->name}}</td>
                                <td>{!! $status->status !!}</td>
                                <td>{{$status->description}}</td>
                                <td>{{$status->created_at}}</td>
                                <td class="tooltip-demo">
                                    <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('project/projectstatus/list.edit') }}" data-id="{{$status->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm del_btn" data-original-title="{{ trans('project/projectstatus/list.del') }}" data-id="{{$status->id}}">
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
                        <h3 class="font-bold">{{ trans('project/projectstatus/list.no_data') }}</h3>
                        <div class="error-desc">
                            {{ trans('project/projectstatus/list.no_data_tip') }}
                            <br><a class="btn btn-primary m-t create-btn" >{{ trans('project/projectstatus/list.create') }}</a>
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
          title: "{{ trans('project/projectstatus/save.create_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '520px'],
          offset: '12%',
          shift: 2,
          content: ["{{ url('projectstatus/create') }}", 'no'], //iframe的url，no代表不显示滚动条
        });
    })
    
    $('.edit_btn').click(function() {
        var statusid = $(this).attr('data-id')
        //iframe窗
        layer.open({
          type: 2,
          title: "{{ trans('project/projectstatus/save.edit_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '520px'],
          offset: '12%',
          shift: 2,
          content: ['projectstatus/'+statusid+'/edit', 'no'], //iframe的url，no代表不显示滚动条
        });
    })

    $('.del_btn').click(function () {
          var statusid = $(this).attr('data-id')
          layer.confirm("{{ trans('project/projectstatus/list.del_confirm') }}", {
            offset: '25%',
            time: 20000, //20s后自动关闭
            btn: ["{{ trans('project/projectstatus/list.yes') }}", "{{ trans('project/projectstatus/list.no') }}"]
          },function () {
              $.ajax({
                  type: "POST",
                  url: "{{ url('projectstatus/destroy') }}",
                  dataType: 'json',
                  cache: false,
                  data: {id:statusid, _token: "{{csrf_token()}}"},
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

