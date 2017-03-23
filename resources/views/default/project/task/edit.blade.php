@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
    <link href="/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <style type="text/css">
        .head{ width: 32px }
        .wrapper-content,.col-sm-12{padding: 0 ;}
        .form-horizontal .checkbox, .form-horizontal .checkbox-inline{padding-top: 0px;}
    </style>
@endsection

@section('content')
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::model($member,['url'=>'projectsmember/update','class'=>'form-horizontal m-t','id'=>'memberForm']) !!}

                          {!! Form::hidden('company_id',Auth::user()->company_id,['id'=>'company_id']) !!}
                          {!! Form::hidden('id',null,['class'=>'memberid']) !!}
                          @include($cfg_style.'.project.member.form')

                        {!! Form::close() !!}
                        
                        <!--替换成员 开始-->
                        <div class="modal inmodal fade" id="replaceModel" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                {!! Form::model($member,['url'=>'','class'=>'form-horizontal m-t','id'=>'replaceForm']) !!}
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h6 class="modal-title">{{ trans('project/member/list.replace_member') }}</h6>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    {!! Form::label(trans('project/show.current_members'),null,['class'=>'col-sm-3 control-label']) !!}
                                                    <div class="col-sm-9" id="projectMembers">
                                                        <a title="{{ $user->name }}" class="edit_member">
                                                            <img src="{{ $user->head_portrait }}" class="img-circle head" alt="{{ $user->name }}">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    {!! Form::label(trans('project/show.all_members'),null,['class'=>'col-sm-3 control-label']) !!}
                                                    <div class="col-sm-9" id="projectMembers">
                                                    @foreach($all_users as $user)
                                                        <div class="radio radio-info radio-inline">
                                                            {!! Form::radio('bereplace_id', $user->id, null, array('id' => 'inlineRadio'.$user->id)) !!}
                                                            <label for="inlineRadio10">
                                                                <img src="{{ $user->head_portrait }}" class="img-circle head" alt="{{ $user->name }}" >
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group description">
                                                {!! Form::label(trans('project/member/fields.description'),null,['class'=>'col-sm-3 control-label']) !!}
                                                <div class="col-sm-9">
                                                {!! Form::textarea('description',null,['class'=>'form-control','rows'=>2]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::hidden('id',null) !!}
                                        {!! Form::hidden('company_id',null,['id'=>'company_id']) !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('customer/customersdynamic/list.close') }}</button>
                                        <button class="btn btn-primary" >{{ trans('customer/customersdynamic/list.yes') }}</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <!--替换成员 结束-->
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
$(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    var icon = "<i class='fa fa-times-circle'></i> ";
    /*提交替换信息*/
    $("#replaceForm").validate({
        rules: {
            //bereplace_id:"required",
        },
        messages: {
            //bereplace_id: icon + "{{ trans('project/member/save.bereplace_required') }}"
        },submitHandler:function(form){
            $.ajax({
                  type: "post",
                  url: "{{ url('projects/members/replace') }}",
                  dataType: 'json',
                  cache: false,
                  data: $('#replaceForm').serialize(),
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

    $('#member_submist').click(function () {
        $.ajax({
            type: "post",
            url: "{{ url('projects/members/update') }}",
            dataType: 'json',
            cache: false,
            data: $('#memberForm').serialize(),
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
        return false;
    })

});
</script>
@endsection

