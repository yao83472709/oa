@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
    <link href="/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <style type="text/css">
    .datepicker {z-index: 3045 !important;}
    </style>
@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                 @if($customers)
                    <div class="ibox-title">
                        <h5>{{ trans('customer/list.page_title') }}</h5>
                        <div class="ibox-tools">
                            <a class="btn btn-primary btn-xs create-btn">{{ trans('customer/list.create') }}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button class="btn btn-white btn-sm refresh-link" id="loading-example-btn" type="button">
                                    <i class="fa fa-refresh"></i> {{ trans('customer/list.refresh') }}
                                </button>
                            </div>
                            <div class="col-md-11">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" placeholder="{{ trans('list.customer.placeholder') }}"> 
                                    <span class="input-group-btn">
                                        <button class="btn btn-sm btn-primary" type="button">
                                            <i class="fa fa-search"></i> {{ trans('customer/list.search') }}
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
                                                    <th data-toggle="true">{{ trans('customer/fields.name') }}</th>
                                                    <th>{{ trans('customer/fields.salesman') }}</th>
                                                    <th>{{ trans('customer/fields.developer') }}</th>
                                                    <th>{{ trans('customer/fields.business_type') }}</th>
                                                    <th>{{ trans('customer/fields.created_at') }}</th>
                                                    <th>{{ trans('customer/fields.status') }}</th>
                                                    <th>{{ trans('customer/fields.news') }}</th>
                                                    <th>{{ trans('customer/fields.action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($customers as $customer)
                                                    <tr>                                                       
                                                        <td >{{ $customer->name }}</td>
                                                        @if($customer->salesman)
                                                        <td >
                                                            <a data-id="{{ $customer->developer->id }}" class="client-link client-avatar">
                                                                <img alt="image" src="{{ $customer->salesman->head_portrait }}">
                                                                {{ $customer->salesman->name }}
                                                            </a>
                                                        </td>
                                                        @else
                                                        <td class="client-status">
                                                            <span class="label label-warning">{{ trans('customer/list.not_assigned') }}</span>
                                                        </td>
                                                        @endif
                                                        <td>
                                                            <a data-id="{{ $customer->developer->id }}" class="client-link client-avatar">
                                                                <img alt="image" src="{{ $customer->developer->head_portrait }}">
                                                                {{ $customer->developer->name }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $customer->business_type }}</td>
                                                        <td >{{ $customer->created }}</td>                                                        
                                                        <td class="client-status">{!! $customer->text_status !!}</td>
                                                        <td class="client-status">
                                                        @if($customer->status_id)
                                                            <span class="label label-primary">{{ $customer->news }}</span>
                                                            {{ $customer->updated }}
                                                        @else
                                                            <span class="label label-danger">{{ $customer->news }}</span>
                                                        @endif
                                                        </td>
                                                        <td class="tooltip-demo">
                                                            <button  data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm more_btn" data-original-title="{{ trans('customer/list.more') }}" data-id="{{$customer->id}}" >
                                                                <i class="fa fa-user"></i>
                                                            </button>
                                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm edit_btn" data-original-title="{{ trans('customer/list.edit') }}" data-id="{{$customer->id}}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            @if(Auth::user()->is_salesman)
                                                            <button ata-placement="top" class="btn btn-white btn-sm addnews" data-toggle="modal" data-target="#myModal5" data-id="{{$customer->id}}">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="12" class="footable-visible">
                                                        <ul class="pagination pull-right">

                                                        </ul>
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
                        <h3 class="font-bold">{{ trans('customer/list.no_data') }}</h3>
                        <div class="error-desc">
                            {{ trans('customer/list.no_data_tip') }}
                            <br><a class="btn btn-primary m-t create-btn" >{{ trans('customer/list.create') }}</a>
                        </div>
                    </div>
                @endif
                    <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h5 class="modal-title">{{ trans('customer/list.news') }}</h5>
                                </div>
                                <div class="modal-body">
                                    <p>{!! trans('customer/customersdynamic/list.news_tip') !!}</p>
                                    {!! Form::open(['url'=>'customersdynamic/store','class'=>'form-horizontal m-t','id'=>'dynamicForm']) !!}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                              {!! Form::label(trans('customer/customersdynamic/fields.status'),null,['class'=>'col-sm-3 control-label']) !!}
                                              <div class="col-sm-9">
                                              {!! Form::select('status_id', $customer_status,null, array('class' => 'form-control')) !!}
                                              </div>                                                
                                            </div>
                                            <div class="form-group">
                                              {!! Form::label(trans('customer/customersdynamic/fields.content'),null,['class'=>'col-sm-3 control-label']) !!}
                                              <div class="col-sm-9">
                                              {!! Form::textarea('content',null,['class'=>'form-control','rows'=>3]) !!}
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              {!! Form::label(trans('customer/customersdynamic/fields.next_time'),null,['class'=>'col-sm-3 control-label']) !!}
                                              <div class="col-sm-9">
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    {!! Form::text('next_time',null,['class'=>'form-control']) !!}
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                        {!! Form::hidden('company_id',Auth::user()->company_id) !!}
                                        {!! Form::hidden('customer_id',null,['id'=>'customer_id']) !!}
                                        {!! Form::hidden('user_id',Auth::user()->id) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('customer/customersdynamic/list.close') }}</button>
                                    <button type="button" class="btn btn-primary news">{{ trans('customer/customersdynamic/list.yes') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</body>
@endsection

@section('self_js')
<!-- 自定义js -->
<script src="/js/content.js?v=1.0.0"></script>
<!-- Data picker -->
<script src="/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script>
$(function () {
    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    /*查看详情*/
    $('.more_btn').click(function () {
        var customer_id = $(this).attr('data-id')
        layer.open({
          type: 2,
          title: "{{ trans('customer/list.details') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '8%',
          shift: 2,
          content: ["{{ url('mycustomers_show') }}/"] + customer_id,//iframe的url，no代表不显示滚动条
        });
    })
    /*新建客户*/
    $('.create-btn').click(function () {
         layer.open({
          type: 2,
          title: "{{ trans('customer/save.create_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '8%',
          shift: 2,
          content: ["{{ url('customers/create') }}"],
        });
    })
    /*编辑客户*/
    $('.edit_btn').click(function() {
        var customer_id = $(this).attr('data-id')
        //iframe窗
        layer.open({
          type: 2,
          title: "{{ trans('customer/save.edit_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '700px'],
          offset: '10%',
          shift: 2,
          content: ['customers/'+customer_id+'/edit'],
        });
    })
    /*添加动态*/
    $('.addnews').click(function () {
        var customer_id = $(this).attr('data-id');
        $('#customer_id').val(customer_id);
    })
    $('.news').click(function () {
        $("#dynamicForm").submit();
    })
    var icon = "<i class='fa fa-times-circle'></i> ";
    $("#dynamicForm").validate({
        rules: {
            company_id:"required",
            status_id:"required",
            user_id:"required",     
            content:"required",       
        },
        messages: {
            company_id: icon + "{{ trans('customer/customersdynamic/save.sys_error') }}",
            status_id: icon + "{{ trans('customer/customersdynamic/save.status_required') }}",
            user_id: icon + "{{ trans('customer/customersdynamic/save.sys_error') }}",
            content: icon + "{{ trans('customer/customersdynamic/save.content_required') }}",
        },submitHandler:function(form){
            $.ajax({
                  type: "POST",
                  url: "{{ url('customersdynamic/store') }}",
                  dataType: 'json',
                  cache: false,
                  data: $('#dynamicForm').serialize(),
                  success: function(data) {                        
                      layer.msg(data.message, {icon: 1});
                      setTimeout(function () {
                        location.reload(); // 父页面刷新
                      },1000); 
                  },
                  error: function(xhr) {
                     $.each(xhr.responseJSON,function(n,value) {   
                            layer.msg(value+'', {icon: 7});
                    });  
                  }
            });
        }    
    });
});
</script>
@endsection


