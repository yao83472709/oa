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
                 @if($applys)
                    <div class="ibox-title">
                        <h5>{{ trans('customer/apply/list.page_title') }}</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button class="btn btn-white btn-sm refresh-link" id="loading-example-btn" type="button">
                                    <i class="fa fa-refresh"></i> {{ trans('customer/apply/list.refresh') }}
                                </button>
                            </div>
                            <div class="col-md-11">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" placeholder="{{ trans('customer/apply/list.placeholder') }}"> 
                                    <span class="input-group-btn">
                                        <button class="btn btn-sm btn-primary" type="button">
                                            <i class="fa fa-search"></i> {{ trans('customer/apply/list.search') }} 
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
                                                    <th data-toggle="true">{{ trans('customer/apply/fields.name') }}</th>
                                                    <th>{{ trans('customer/apply/fields.applicant') }}</th>
                                                    <th>{{ trans('customer/apply/fields.created_at') }}</th>
                                                    <th>{{ trans('customer/apply/fields.status') }}</th>
                                                    <th>{{ trans('customer/apply/list.action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($applys as $apply)
                                                    <tr>                      
                                                        <td>{{ $apply->customer->name }}</td>
                                                        <td>
                                                            <a data-id="{{ $apply->maker->id }}" class="client-link client-avatar">
                                                                <img alt="image" src="{{ $apply->maker->head_portrait }}">
                                                                {{ $apply->maker->name }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $apply->created }}</td>
                                                        <td class="client-status">
                                                            {!! $apply->text_status !!}
                                                        </td>
                                                        <td class="tooltip-demo">
                                                            <div class="input-group m-b">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-primary more_btn" data-id="{{$apply->id}}" type="button">{{ trans('customer/apply/list.more') }}</button>
                                                                </span>
                                                                <select name="action" class="form-control m-b action" data-id="{{ $apply->id }}">
                                                                  <option @if($apply->status == 0) selected=""  @endif value="0">{{ strip_tags(trans('customer/apply/list.status.0')) }}</option>
                                                                  <option @if($apply->status == 1) selected=""  @endif value="1">{{ strip_tags(trans('customer/apply/list.status.1')) }}</option>
                                                                  <option @if($apply->status == 2) selected=""  @endif value="2">{{ strip_tags(trans('customer/apply/list.status.2')) }}</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="12" class="footable-visible">
                                                        {!! $applys->render() !!}
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
                        <h3 class="font-bold">{{ trans('customer/apply/list.no_data') }}</h3>
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
<script>
$(function () {
    $('.full-height-scroll').slimScroll({
        height: '100%'
    });
    /*更新申请*/
    $('.action').change(function () {
        var apply_id = $(this).attr('data-id');
        var status = $(this).val();
        $.ajax({
            type: "POST",
            url: "{{ url('documentary/distribution') }}",
            dataType: 'json',
            cache: false,
            data: {'id':apply_id, 'info[examine_id]':{{ Auth::user()->id }}, 'info[status]':status, '_token':"{{ csrf_token() }}"},
            success: function(data) {
                if(data.status) {
                  layer.msg(data.message, {icon: 7});
                  return false;
                }
                layer.msg(data.message, {icon: 1});
                setTimeout(function () {
                  location.reload();
                },1000); 
            },
            error: function(xhr) {
               $.each(xhr.responseJSON,function(n,value) {   
                  layer.msg(value+'', {icon: 7});
              });
            }
       });
    })
    /*查看详情*/
    $('.more_btn').click(function () {
        var customer_id = $(this).attr('data-id')
        layer.open({
          type: 2,
          title: "{{ trans('customer/apply/list.details') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '8%',
          shift: 2,
          content: ["{{ url('mycustomers_show') }}/"] + customer_id,//iframe的url，no代表不显示滚动条
        });
    })

    /*删除客户*/
    $('.del_btn').click(function () {
          var customer_id = $(this).attr('data-id')
          layer.confirm('确定要删除吗？', {
            offset: '25%',
            time: 20000, //20s后自动关闭
            btn: ['确定', '取消']
          },function () {
              $.ajax({
                  type: "POST",
                  url: "{{ url('customers/destroy') }}",
                  dataType: 'json',
                  cache: false,
                  data: {'id':customer_id, _token:"{{ csrf_token() }"},
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


