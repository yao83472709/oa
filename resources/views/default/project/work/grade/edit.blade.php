@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
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
                        {!! Form::model($grade,['url'=>'','class'=>'form-horizontal m-t','id'=>'gradeForm']) !!}
    
                            @include($cfg_style.'.project.work.grade.form')
                            {!! Form::hidden('id',null,['class'=>'gradeid']) !!}

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
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>
<script>
$(document).ready(function () {        
    var icon = "<i class='fa fa-times-circle'></i> ";
    $("#gradeForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
        },
        messages: {
            name: {
                required: icon + "{{ trans('project/work/grade/save.name_required') }}",
                minlength: icon + "{{ trans('project/work/grade/save.name_min') }}"
            },
        },submitHandler:function(form){
            $.ajax({
                  type: "post",
                  url: "{{ url('workgrade/update') }}",
                  dataType: 'json',
                  cache: false,
                  data: $('#gradeForm').serialize(),
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

