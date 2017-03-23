@extends($cfg_style.'.layouts.master')
@section('title',$cfg_company.'_'.$cfg_webname)
@section('content')
    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">


                        {!! Form::open(array('class'=>'form-horizontal m-t','id'=>'runTypeFrom')) !!}

                            @include($cfg_style.'.account.runtype.form')
                        {{--公司id --}}
                        <div class="form-group price_range" style="display: none">
                            {!! Form::text('company_id',$company_id,['id'=>'runtype_name','class'=>'form-control',]) !!}
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
    <script src="/js/plugins/validate/jquery.validate.min.js"></script>
    <script>

        if($('#status_out').is(':checked')){
            displaySelect();
            getsystype();
        };
        $('#status_out').click(function(){
            displaySelect();
            getsystype();
        });
        if($('#status_in').is(':checked')){
            displayNOSelect();
        };
        $('#status_in').click(function(){
            displayNOSelect();
        });


        var icon = "<i class='fa fa-times-circle'></i> ";
        //自定义金额验证方式
        jQuery.validator.addMethod("statusOut", function(value, element) {
            if($('#status_out').is(':checked')){
                if($('.displaySelect select').val()==0) return false;
                else return true;
            }
            return true;
        }, "请选择支出种类");
        $("#runTypeFrom").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                status: {
                    required: true,
                    statusOut: true
                }

            },
            messages: {
                name: {
                    required: icon + "{{ trans('account\save.runtype.validate.name_required') }}",
                    minlength: icon + "{{ trans('account\save.runtype.validate.min_length') }}"
                },
                status: {
                    required: icon + "{{ trans('account\save.runtype.validate.status') }}"
                }
            }, submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/account/runtype/create') }}",
                    dataType: 'json',
                    cache: false,
                    data: $('#runTypeFrom').serialize(),
                    success: function(data) {
                        layer.msg(data.message,{icon:data.msgnum});
                        if(data.state==1){
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


            }
        });

        function getsystype(){
            var load=$('#status_out').attr('data-load');
            if(load==0){
                $.ajax({
                    type:'POST',
                    url:"{{ url('/account/runtype/systype') }}",
                    data:'id='+1,
                    success:function(datas){
                        $('#status_out').attr('data-load',1);
                        var obj=eval(datas);
                        var str= '<option value="0" selected="selected">请选择</option>';
                        $.each(obj,function(n,data){
                            str+= '<option value="'+data.id+'">'+data.name+'</option>';
                        });
                        $('#select_name option').remove();
                        $('#select_name').append(str);
                    },
                    error:function(xhr){
                        $.each(xhr.responseJSON,function(n,value) {
                            $.each(value,function(n,data){
                                layer.msg(data.message, {icon: data.msgnum});
                            });
                        });
                    }
                });
            }

        }
        function displayNOSelect(){
            $('.displaySelect').css('display','none');
            $('.displaySelect select').attr('disabled','disabled');
        }
        function displaySelect(){
            $('.displaySelect').css('display','block');
            $('.displaySelect select').removeAttr('disabled');
        }






    </script>
@endsection