@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
    <link href="/css/plugins/footable/footable.core.css" rel="stylesheet">
    <style type="text/css">
        .col-md-1{padding-left: 0px;}
    </style>
@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                @if($origins)
                    <div class="ibox-title">
                        <h5>{{ trans('list.business_origin.page_title') }}</h5>
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
                                <th data-toggle="true">{{ trans('customer/businessorigin/fields.name') }}</th>
                                <th>{{ trans('common.status') }}</th>
                                <th>{{ trans('common.sort') }}</th>
                                <th data-hide="all">{{ trans('customer/businessorigin/fields.description') }}</th>
                                <th data-hide="all">{{ trans('customer/businessorigin/fields.created_at') }}</th>
                                <th>{{ trans('customer/businessorigin/list.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            {!! Form::open(['id'=>'sortForm']) !!}
                            {!! Form::hidden('company_id',Auth::user()->company_id,['class'=>'company_id']) !!}
                            @foreach ($origins as $origin)
                            <tr>
                                <td>{{ $origin->name }}</td>
                                <td>{!! trans('common.show_status_val.'.$origin->status) !!}</td>
                                <td>
                                    <div class="col-md-1">
                                        {!! Form::text("origins[$origin->id]",$origin->sort,['class'=>'form-control']) !!}                                        
                                    </div>
                                </td>
                                <td>{{ $origin->description }}</td>
                                <td>{{ $origin->created_at }}</td>
                                <td>                
                                    <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('customer/businessorigin/list.edit') }}" data-id="{{ $origin->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm del_btn" data-original-title="{{ trans('customer/businessorigin/list.del') }}" data-id="{{ $origin->id }}">
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
                                    <ul class="pagination pull-right "></ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="middle-box text-center animated fadeInRightBig">
                        <h3 class="font-bold">{{ trans('customer/businessorigin/list.no_data') }}</h3>
                        <div class="error-desc">
                            {{ trans('customer/businessorigin/list.no_data_tip') }}
                            <br><a class="btn btn-primary m-t create-btn" >{{ trans('customer/businessorigin/list.create') }}</a>
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
          title: "{{ trans('customer/businessorigin/save.create_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '520px'],
          offset: '12%',
          shift: 2,
          content: ["{{ url('businessorigin/create') }}", 'no'], //iframe的url，no代表不显示滚动条
        });
    })
    
    $('.edit_btn').click(function() {
        var originid = $(this).attr('data-id')
        console.log('businessorigin/'+originid+'/edit')
        //iframe窗
        layer.open({
          type: 2,
          title: "{{ trans('customer/businessorigin/save.edit_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '520px'],
          offset: '12%',
          shift: 2,
          content: ['businessorigin/'+originid+'/edit', 'no'], //iframe的url，no代表不显示滚动条
        });
        return false
    })

    $('.del_btn').click(function () {
        var originid = $(this).attr('data-id')
        layer.confirm("{{ trans('customer/businessorigin/list.del_confirm') }}", {
          offset: '25%',
          time: 20000, //20s后自动关闭
          btn: ["{{ trans('customer/businessorigin/list.yes') }}", "{{ trans('customer/businessorigin/list.no') }}"]
        },function () {
            $.ajax({
                type: "POST",
                url: "{{ url('businessorigin/destroy') }}",
                dataType: 'json',
                cache: false,
                data: {'id':originid, _token:"{{ csrf_token() }}"},
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
          url: "{{ url('businessorigin/sort') }}",
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

