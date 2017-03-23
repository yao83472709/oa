@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
<link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::open(['url'=>'','class'=>'form-horizontal m-t','id'=>'usersForm']) !!}

                            {!! Form::hidden('type',$type)  !!}
                            @foreach($departments as $department)
                            <div class="form-group">
                                {!! Form::label($department->name,null,['class'=>'col-sm-2 control-label']) !!}                                
                                <div class="col-sm-9">
                                    @foreach($users as $user)
                                    @if($user->department_id == $department->id)
                                    <label class="checkbox-inline i-checks">
                                        <input type="checkbox" name="users[]" value="{{ $user->id }}" @if($user->checked) checked="true" @endif >{{ $user->name }} 
                                    </label>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary">{{ trans('project/fields.submit') }}</button>
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
<script>
$(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    $('#usersForm').submit(function () {        
        $.ajax({
            type: "POST",
            url: "{{ url('bajie/noticeUpdate') }}",
            dataType: 'json',
            cache: false,
            data: $("#usersForm").serialize(),
            async: false,
            success: function(data) {
              if(data.status == 0) {
                  layer.msg(data.message, {icon: 1});
                  setTimeout(function () {
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
        return false;
    })
});
</script>
@endsection

