@extends($httpView.'.layouts.master')
@section('title')
    {{ $httpTitle }}
@endsection
@section('content')
    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">


                        {!! Form::open(array('class'=>'form-horizontal m-t','id'=>'projectid')) !!}
                        {{--项目名 --}}
                        <div style="display:none">
                            {!! Form::text('project_name',$id,['id'=>'project_name','class'=>'form-control','display'=>'none']) !!}
                        </div>
                        @include($httpView.'.account.form')

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection

@section('self_js')
    <script>
        $.ajax({
            type:'POST',
            url:'/account/project/getprojectid',
            data:'id='+{{$id}},
            success:function(data){
                var obj=eval(data);
                $('#agreement_number').val(obj[0]['agreement_number']);
                $('#total_price').val(obj[0]['total_price']);
                $('#payment_ratio').val(obj[0]['payment_ratio']);
                $('#stagestr').val(obj[0]['stagestr']);
                $('#price').val(obj[0]['stage_price']);
            },
            error:function(){
                $('.ibox-content').remove();
            }
        });
        $('#submitButton').click(function(){
            $.ajax({
                type: "POST",
                url: "{{ url('/account/project/create') }}",
                dataType: 'json',
                cache: false,
                data: $('#projectid').serialize(),
                success: function(data) {
                    layer.msg(data.message,{icon:data.msgnum});
                    if(data.status==1){
                        parent.location.reload(); // 父页面刷新
                        setTimeout(function () {
                            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            parent.layer.close(index); //再执行关闭
                        },6000);
                    }
                },
                error: function(xhr) {
                    $.each(xhr.responseJSON,function(n,value) {
                        $.each(value,function(n,data){
                            layer.msg(data.message, {icon: data.msgnum});
                        });
                    });
                }
            });
        });





    </script>
@endsection