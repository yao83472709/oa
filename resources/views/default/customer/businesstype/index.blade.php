@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
    <link href="/css/plugins/footable/footable.core.css" rel="stylesheet">
    <style type="text/css">
        .col-md-2{padding-left: 0px;width: 12%}
    </style>
@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                 @if($types->count())
                    <div class="ibox-title">
                        <h5>{{ trans('customer/businesstype/list.page_title') }}</h5>
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
                                <th data-toggle="true">{{ trans('customer/businesstype/fields.name') }}</th>
                                <th>{{ trans('customer/businesstype/fields.price_range') }}</th>
                                <th>{{ trans('customer/businesstype/fields.time_range') }}</th>
                                <th>{{ trans('common.status') }}</th>
                                <th>{{ trans('common.sort') }}</th>
                                <th data-hide="all">{{ trans('customer/businesstype/fields.description') }}</th>
                                <th data-hide="all">{{ trans('customer/businesstype/fields.created_at') }}</th>
                                <th>{{ trans('customer/businesstype/list.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            {!! Form::open(['id'=>'sortForm']) !!}
                            {!! Form::hidden('company_id',Auth::user()->company_id,['class'=>'company_id']) !!}
                            @foreach ($types as $type)
                            <tr>
                                <td>{{$type->name}}</td>
                                <td>￥{{$type->price_range}}</td>
                                <td>{{$type->time_range}}</td>
                                <td>{!! trans('common.show_status_val.'.$type->status) !!}</td>
                                <td>
                                    <div class="col-md-2">
                                        {!! Form::text("types[$type->id]",$type->sort,['class'=>'form-control']) !!}                                        
                                    </div>
                                </td>
                                <td>{{$type->description}}</td>
                                <td>{{$type->created_at}}</td>
                                <td class="tooltip-demo">
                                    <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('customer/businesstype/list.edit') }}" data-id="{{$type->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm del_btn" data-original-title="{{ trans('customer/businesstype/list.del') }}" data-id="{{$type->id}}">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            {!! Form::close() !!}
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="8">
                                    <button class="btn btn-primary sortbtn" type="submit">{{ trans('common.sort') }}</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="middle-box text-center animated fadeInRightBig">
                        <h3 class="font-bold">{{ trans('customer/businesstype/list.no_data') }}</h3>
                        <div class="error-desc">
                            {{ trans('customer/businesstype/list.no_data_tip') }}
                            <br><a class="btn btn-primary m-t create-btn" >{{ trans('customer/businesstype/list.create') }}</a>
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
          title: "{{ trans('customer/businesstype/save.create_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '12%',
          shift: 2,
          content: ["{{ url('businesstype/create') }}", 'no'], //iframe的url，no代表不显示滚动条
        });
    })
    
    $('.edit_btn').click(function() {
        var typeid = $(this).attr('data-id')
        //iframe窗
        layer.open({
          type: 2,
          title: "{{ trans('customer/businesstype/save.edit_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '12%',
          shift: 2,
          content: ['businesstype/'+typeid+'/edit', 'no'], //iframe的url，no代表不显示滚动条
        });
        return false
    })

    $('.del_btn').click(function () {
        var typeid = $(this).attr('data-id')
        layer.confirm("{{ trans('customer/businesstype/list.del_confirm') }}", {
          offset: '25%',
          time: 20000, //20s后自动关闭
          btn: ["{{ trans('customer/businesstype/list.yes') }}", "{{ trans('customer/businesstype/list.no') }}"]
        },function () {
            $.ajax({
                type: "POST",
                url: "{{ url('businesstype/destroy') }}",
                dataType: 'json',
                cache: false,
                data: {'id':typeid, _token:"{{ csrf_token() }}"},
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
        return false
    })

    $('.sortbtn').click(function () {
      $.ajax({
          type: "POST",
          url: "{{ url('businesstype/sort') }}",
          dataType: 'json',
          cache: false,
          data: $('#sortForm').serialize(),
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
    })

});

</script>

@endsection

