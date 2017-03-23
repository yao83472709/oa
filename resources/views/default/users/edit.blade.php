@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
    <link href="/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <style type="text/css">
     .wrapper-content,.col-sm-12{padding: 0 ;}
    </style>
@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::model($user,['url'=>'users/update','class'=>'form-horizontal m-t','id'=>'usersForm']) !!}

                            {!! Form::hidden('id',null,['class'=>'customerid']) !!}
                            @include($cfg_style.'.users.form')
                            
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
<!-- Chosen -->
<script src="/js/plugins/chosen/chosen.jquery.js"></script>
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<!-- Data picker -->
<script src="/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>

<script src="/js/area.js"></script>
<script>
$(document).ready(function () {
    $('#data_2 .input-group.date').datepicker({
        startView: 2,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
    $('#data_3 .input-group.date').datepicker({
        startView: 2,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });

    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {
            allow_single_deselect: true
        },
        '.chosen-select-no-single': {
            disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
            no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
            width: "95%"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    var icon = "<i class='fa fa-times-circle'></i> ";
    $("#usersForm").validate({
        rules: {
            number: {
                required: true,
                minlength: 6,
            },            
            username: {
                required: true,
                minlength: 11,
                maxlength: 11,
            },
            password: {
                minlength: 6
            },
            confirm_password: {
                minlength: 6,
                equalTo: ".password"
            },            
            name: {
                required: true,
                minlength: 2
            },
            role_id:"required",
            power_group_id:"required",
            email: {
                        email: true
                    },
        },
        messages: {
            number: {
                required: icon + "{{ trans('user/save.number_required') }}",
                minlength: icon + "{{ trans('user/save.number_min') }}",
            },
            username: {
                required: icon + "{{ trans('user/save.username_required') }}",
                minlength: icon + "{{ trans('user/save.username_min') }}",
                maxlength: icon + "{{ trans('user/save.username_max') }}",
            },
            password: {
                minlength: icon + "{{ trans('user/save.password_min') }}",
            },
            confirm_password: {
                minlength: icon + "{{ trans('user/save.confirm_min') }}",
                equalTo: icon + "{{ trans('user/save.pwd_error') }}"
            },
            name: {
                required: icon + "{{ trans('user/save.name_required') }}",
                minlength: icon + "{{ trans('user/save.name_min') }}"
            },
            department_id: icon + "{{ trans('user/save.department_required') }}",
            power_group_id: icon + "{{ trans('user/save.power_required') }}",
            eamil: icon + "{{ trans('user/save.email_error') }}",
            
        },submitHandler:function(form){
            $.ajax({
                  type: "POST",
                  url: "{{ url('users/update') }}",
                  dataType: 'json',
                  cache: false,
                  data: $('#usersForm').serialize(),
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
        }    
    });

});
</script>
@endsection

