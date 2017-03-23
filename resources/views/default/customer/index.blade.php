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
                                    <i class="fa fa-refresh"></i> {{ trans('common.refresh') }}
                                </button>
                            </div>
                            <div class="col-md-11">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" placeholder="{{ trans('customer/list.placeholder') }}"> 
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
                                                    <th>{{ trans('customer/fields.action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($customers as $customer)
                                                    <tr>                                                       
                                                        <td >{{ $customer->name }}</td>
                                                        @if($customer->salesman_id)
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
                                                        <td >
                                                             {{ $customer->created }}
                                                        </td>
                                                        <td class="client-status">
                                                            {!! $customer->text_status !!}
                                                            @if($customer->isapply)
                                                                <span class="label label-default">{{ trans('customer/list.already') }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="tooltip-demo">
                                                            <button data-placement="top" data-toggle="tooltip"  class="btn btn-white btn-sm more_btn" data-original-title="{{ trans('customer/list.more') }}" data-id="{{$customer->id}}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-white btn-sm documentary" data-original-title="{{ trans('customer/list.documentary') }}" data-id="{{$customer->id}}" data-isapply="{{ $customer->isapply }}">
                                                                <i class="fa fa-user"></i>
                                                            </button>
                                                            @level(2)
                                                            <button data-placement="top" class="btn btn-white btn-sm adddistributionbtn" data-toggle="modal" data-target="#myModal5" data-id="{{$customer->id}}">
                                                                <i class="fa fa-user"></i>{{ trans('customer/list.distribution') }}
                                                            </button>
                                                            @endlevel                                                  
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="12" class="footable-visible">
                                                        {!! $customers->render() !!}
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
                
                @level(2)
                    <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h5 class="modal-title">{{ trans('customer/list.distribution') }}</h5>
                                </div>
                                <div class="modal-body">
                                    <p>{!! trans('customer/list.distribution_tip') !!}</p>
                                    <form  accept-charset="utf-8" role="form" id="distributionForm">
                                    {!! Form::open(['url'=>'documentary/dodistribution','id'=>'distributionForm']) !!}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                {!! Form::text('salename',null,['class'=>'form-control','id'=>'salename']) !!}
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::hidden('salesman_id',null,['id'=>'salesman_id']) !!}
                                    {!! Form::hidden('customer_id',null,['id'=>'customer_id']) !!}
                                    {!! Form::hidden('make_id',Auth::user()->id) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('customer/list.close') }}</button>
                                    <button type="button" class="btn btn-primary distribution">{{ trans('customer/list.yes') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endlevel
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
    /*分配业务员*/
    $('.adddistributionbtn').click(function () {
      var customer_id = $(this).attr('data-id');
      $('#customer_id').val(customer_id);
    })
    var testBsSuggest = $("#salename").bsSuggest({
        url: "{{ url('getsalesmans/'.Auth::user()->company_id) }}",
        effectiveFields: ["name", "number", "username"],
        searchFields: [ "name"],
        effectiveFieldsAlias:{name: "{{ trans('customer/fields.name') }}", number: "{{ trans('customer/fields.number') }}", username: "{{ trans('customer/fields.username') }}"},
        idField: "id",
        keyField: "name"
    }).on('onDataRequestSuccess', function (e, result) {
        console.log('onDataRequestSuccess: ', result);
    }).on('onSetSelectValue', function (e, keyword) {
        $('#salesman_id').val(keyword.id)
    }).on('onUnsetSelectValue', function (e) {
        console.log("onUnsetSelectValue");
    });
    $('.distribution').click(function () {
        $.ajax({
            type: "POST",
            url: "{{ url('documentary/dodistribution') }}",
            dataType: 'json',
            cache: false,
            data: $('#distributionForm').serialize(),
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
    /*申请跟单*/
    $('.documentary').click(function () {
          if($(this).attr('data-isapply')) {
             layer.msg("{{ trans('customer/save.aready') }}", {icon: 7});
             return false;
          }
          var customer_id = $(this).attr('data-id')
          layer.confirm("{{ trans('customer/list.confirm_documentary') }}", {
            offset: '25%',
            time: 20000, //20s后自动关闭
            btn: ["{{ trans('customer/list.yes') }}", "{{ trans('customer/list.no') }}"]
          },function () {
              $.ajax({
                  type: "POST",
                  url: "{{ url('documentary/store') }}",
                  dataType: 'json',
                  cache: false,
                  data: {'company_id':{{ Auth::user()->company_id }}, 'customer_id':customer_id, 'type':2, 'make_id':{{ Auth::user()->id }}, _token: "{{csrf_token()}}"},
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
          },function (index) {
              layer.close(index);
          });
    })
    /*查看详情*/
    $('.more_btn').click(function () {
        var customer_id = $(this).attr('data-id')
        layer.open({
          type: 2,
          title: "{{ trans('customer/save.create_title') }}",
          shadeClose: true,
          shade: false,
          maxmin: true, //开启最大化最小化按钮
          area: ['850px', '650px'],
          offset: '8%',
          shift: 2,
          content: ["{{ url('customers') }}/"] + customer_id,//iframe的url，no代表不显示滚动条
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

});
</script>
@endsection


