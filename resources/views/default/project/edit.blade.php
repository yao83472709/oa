@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
    <link href="/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <style type="text/css">
     .wrapper-content,.col-sm-12{padding: 0 ;}
     .input-group[class*="col-"]{padding-left: 12px;}
     .input-daterange input:first-child {border-radius: 0px;}
    </style>
@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::model($project,['url'=>'','class'=>'form-horizontal m-t','id'=>'projectForm']) !!}
                              
                            {!! Form::hidden('company_id',null,['id'=>'company_id']) !!}
                            {!! Form::hidden('number',null,['id'=>'number']) !!}
                            {!! Form::hidden('id',null,['id'=>'projectid']) !!}
                            @include($cfg_style.'.project.form')
                            
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
<script src="/js/ajaxfileupload.js"></script>
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<!-- Data picker -->
<script src="/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- Input Mask-->
<script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<!-- Prettyfile -->
<script src="/js/plugins/prettyfile/bootstrap-prettyfile.js"></script>
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>
<script>
$(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
    
    $( '#file-pretty input[type="file"]' ).prettyFile();

    var icon = "<i class='fa fa-times-circle'></i> ";
    /*提交数据*/
    function ajaxForm(data) {
        $.ajax({
              type: "POST",
              url: "{{ url('projects/update') }}",
              dataType: 'json',
              cache: false,
              data: data,
              async: false,
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

    $("#projectForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },      
            start:"required", 
            end:"required", 
            deal_price:"required",
            bonus:"required",
            payment_ratio:"required",
            bonus:"required",
        },
        messages: {
            name: {
                required: icon + "{{ trans('project/save.name_required') }}",
                minlength: icon + "{{ trans('project/save.name_min') }}"
            },
            start: icon + "{{ trans('project/save.start_required') }}",
            end: icon + "{{ trans('project/save.end_required') }}",
            deal_price: icon + "{{ trans('project/save.deal_price_required') }}",
            payment_ratio: icon + "{{ trans('project/save.payment_ratio_required') }}",
            bonus: icon + "{{ trans('project/save.bonus_required') }}"
            
        },submitHandler:function(form){
            var payment_ratio = $('input[name="payment_ratio"]').val().split('-');
            for (var sum = i = 0; i < payment_ratio.length; i++)
                sum += parseInt(payment_ratio[i]);
            if(sum != 10) {
                layer.msg("{{ trans('project/save.payment_ratio_error') }}", {icon: 7});
                return false
            }
            /*上传备案资料*/            
            if($('input[name="record"]').val()) {
                $('input[name="record"]').attr('id','record')
                $.ajaxFileUpload({
                    url: "{{ url('files/upload') }}",
                    type: 'post',
                    secureuri: false,
                    data: {company_id:$('#company_id').val(), type:0, fileName:$('#number').val(), _token:"{{ csrf_token() }}"},
                    fileElementId: 'record',
                    dataType: 'json',
                    async: false,
                    success: function (data) {
                        $('#record_file_suffix').val(data.value.suffix)
                        $('#record_file').val(data.value.path);
                    },
                    error: function (xhr) {
                        $.each(xhr.responseJSON,function(n,value) {   
                            layer.msg(value+'', {icon: 7});
                        });
                    }
                });
            }
            /*上传开发资料*/
            if($('input[name="relevant"]').val()) {
                $('input[name="relevant"]').attr('id','relevant')
                $.ajaxFileUpload({
                    url: "{{ url('files/upload') }}",
                    type: 'post',
                    secureuri: false,
                    data: {company_id:$('#company_id').val(), type:1, fileName:$('#number').val(), _token:"{{ csrf_token() }}"},
                    fileElementId: 'relevant',
                    dataType: 'json',
                    async: false,
                    success: function (data) {
                        $('#relevant_file_suffix').val(data.value.suffix)
                        $('#relevant_file').val(data.value.path);
                        ajaxForm($("#projectForm").serialize());
                    },
                    error: function (xhr) {
                        $.each(xhr.responseJSON,function(n,value) {   
                            layer.msg(value+'', {icon: 7});
                        });
                    }
                });
                return false;
            }
            ajaxForm($("#projectForm").serialize());

        }    
    });

});
</script>
@endsection

