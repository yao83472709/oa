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
                 @if($users->count())
                    <div class="ibox-title">
                        <h5>{{ trans('user/list.page_title') }}</h5>
                        <div class="ibox-tools">
                            <a class="btn btn-primary btn-xs create-btn">{{ trans('user/list.create') }}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button class="btn btn-white btn-sm refresh-link" id="loading-example-btn" type="button">
                                    <i class="fa fa-refresh"></i> {{ trans('common.refresh') }}
                                </button>
                            </div>
                            <div class="col-md-11">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" placeholder="{{ trans('user/list.placeholder') }}"> 
                                    <span class="input-group-btn">
                                        <button class="btn btn-sm btn-primary" type="button">
                                            <i class="fa fa-search"></i> {{ trans('common.search') }}
                                        </button> 
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="clients-list">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th data-toggle="true">{{ trans('user/fields.number') }}</th>
                                                    <th>{{ trans('user/fields.name') }}</th>
                                                    <th>{{ trans('user/fields.nickname') }}</th>
                                                    <th>{{ trans('fields.common.status') }}</th>
                                                    <th>{{ trans('user/fields.department') }}</th>
                                                    <th>{{ trans('user/fields.power_group') }}</th>
                                                    <th>{{ trans('user/fields.created_at') }}</th>                                                    
                                                    <th>{{ trans('common.action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($users as $user)
                                                    <tr>                                                       
                                                        <td >{{ $user->number }}</td>
                                                        <td >
                                                            <a data-id="{{ $user->id }}" class="client-link client-avatar">
                                                                <img src="{{ $user->head_portrait }}">
                                                                {{ $user->name }}
                                                            </a>
                                                        </td>
                                                        <td >{{ $user->nickname }}</td>
                                                        <td>{!! trans('user/list.status.'.$user->status ) !!}</td>
                                                        <td>{{ $user->department }}</td>
                                                        <td >{{ $user->role }}</td>
                                                        <td class="client-status">{{ $user->created }}</td>
                                                        <td class="tooltip-demo">
                                                            <button  data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm more_btn" data-original-title="{{ trans('common.show') }}" data-id="{{$user->id}}" >
                                                                <i class="fa fa-user"></i>
                                                            </button>
                                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('common.edit') }}" data-id="{{$user->id}}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>                                                  
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="12" class="footable-visible">
                                                        {!! $users->render() !!}
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                @else
                    <div class="middle-box text-center animated fadeInRightBig">
                        <h3 class="font-bold">{{ trans('user/list.no_data') }}</h3>
                        <div class="error-desc">
                            {{ trans('common.no_data_tip') }}
                            <br><a class="btn btn-primary m-t create-btn" >{{ trans('user/list.create') }}</a>
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
<script src="/js/content.js?v=1.0.0"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/js/plugins/suggest/bootstrap-suggest.min.js"></script>
<script>
$(function () {
    $('.full-height-scroll').slimScroll({
        height: '100%'
    });
    /*查看详情*/
    $('.more_btn').click(function () {
        var user_id = $(this).attr('data-id')
        layer.open({
          type: 2,
          title: "{{ trans('save.user.create_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '8%',
          shift: 2,
          content: ["{{ url('users') }}/"] + user_id,//iframe的url，no代表不显示滚动条
        });
    })
    /*新建员工*/
    $('.create-btn').click(function () {
         layer.open({
          type: 2,
          title: "{{ trans('user/list.create') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '8%',
          shift: 2,
          content: ["{{ url('users/create') }}"],
        });
    })
    /*编辑员工*/
    $('.edit_btn').click(function() {
        var user_id = $(this).attr('data-id')
        //iframe窗
        layer.open({
          type: 2,
          title: "{{ trans('user/list.edit') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '700px'],
          offset: '10%',
          shift: 2,
          content: ['/users/'+user_id+'/edit'],
        });
    })

    /*删除员工*/
    $('.del_btn').click(function () {
          var user_id = $(this).attr('data-id')
          layer.confirm("{{ trans('common.del_confirm') }}", {
            offset: '25%',
            time: 20000, //20s后自动关闭
            btn: ["{{ trans('common.yes') }}", "{{ trans('common.no') }}"]
          },function () {
              $.ajax({
                  type: "POST",
                  url: "{{ url('users/destroy') }}",
                  dataType: 'json',
                  cache: false,
                  data: {'id':user_id, _token:"{{ csrf_token() }}"},
                  success: function(data) {                 
                      if(data.status == 0) {
                          layer.msg(data.message, {icon: 1});
                          setTimeout(function () {
                              parent.location.reload(); // 父页面刷新
                              var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                              parent.layer.close(index); //再执行关闭
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


