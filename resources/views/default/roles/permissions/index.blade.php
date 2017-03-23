@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
    <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
    <style type="text/css">
    .col-sm-8{height: 30px}
    .form-horizontal .control-label{text-align: left}
    </style>
@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ trans('role/permissions/list.page_title') }}</h5>
                        <div class="ibox-tools">
                            <a class="refresh-link" >
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                      <form class="form-horizontal" id="permissionsForm">
                      {!! Form::open(['url'=>'','class'=>'form-horizontal','id'=>'permissionsForm']) !!}
                        {!! $permissions !!}
                        {!! Form::hidden('roleid',$id,['class'=>'roleid']) !!}
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary">{{ trans('save.form.submit') }}</button>
                            </div>
                        </div>
                      {!! Form::close() !!}
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
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>
<script>
$(document).ready(function() {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    /*分配权限*/
    var icon = "<i class='fa fa-times-circle'></i> ";
    $("#permissionsForm").validate({
        rules: {
            roleid:"required",            
        },
        messages: {
            roleid: icon + "{{ trans('save.common.sys_error') }}"
        },submitHandler:function(form){
            $.ajax({
                  type: "post",
                  url: "{{ url('permissions/fill') }}",
                  dataType: 'json',
                  cache: false,
                  data: $('#permissionsForm').serialize(),
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
        }    
    });

});

</script>

@endsection

