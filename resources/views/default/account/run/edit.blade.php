@extends($cfg_style.'.layouts.master')
@section('title',$cfg_company.'_'.$cfg_webname)
@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        {!! Form::model($datas,['class'=>'form-horizontal m-t','id'=>'runFrom']) !!}
                            {{--id --}}
                            <div class="form-group price_range" style="display: none">
                                {!! Form::text('id',null,['id'=>'id','class'=>'form-control']) !!}
                            </div>
                            @include($cfg_style.'.account.run.form1')

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

@section('self_js')
    <script src="/js/content.js?v=1.0.0"></script>
    <!-- jQuery Validation plugin javascript-->
    <script src="/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/js/plugins/validate/messages_zh.min.js"></script>
<script>
$(document).ready(function () {
    var icon = "<i class='fa fa-times-circle'></i> ";
    $("#runFrom").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            status:{
                required: true
            }
        },
        messages: {
            name: {
                required: icon + "{{ trans('account\save.runtype.validate.name_required') }}",
                minlength: icon + "{{ trans('account\save.runtype.validate.min_length') }}"
            },
            status:{
                required: icon + "{{ trans('account\save.runtype.validate.status') }}"
            }
        },submitHandler:function(form){
             $.ajax({
                  type: "post",
                  url: "{{ url('/account/runtype/edit') }}",
                  dataType: 'json',
                  cache: false,
                  data: $('#runFrom').serialize(),
                  success: function(data) {
                      layer.msg(data.message, {icon: 1});
                      setTimeout(function () {
                        parent.location.reload(); // 父页面刷新
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭
                      },1000); 
                  },
                  error: function(xhr) {
                      $.each(xhr.responseJSON,function(n,value) {
                          $.each(value,function(n,data){
                              layer.msg(data.message, {icon: data.msgnum});
                          });
                      });
                  }
            });
        }    
    });

});
</script>
@endsection

