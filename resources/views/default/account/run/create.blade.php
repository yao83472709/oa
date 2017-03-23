@extends($cfg_style.'.layouts.master')
@section('title',$cfg_company.'_'.$cfg_webname)
@section('content')
    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::open(array('class'=>'form-horizontal m-t','id'=>'runFrom')) !!}
                            @include($cfg_style.'.account.run.form')
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
        getselect();
        var icon = "<i class='fa fa-times-circle'></i> ";
        //自定义金额验证方式
        jQuery.validator.addMethod("isMoney", function(value, element) {
            var tel = /^[0-9]{0,10}.[0-9]{0,2}$/;
            return this.optional(element) || (tel.test(value));
        }, "请正确填写您的金额");
        $("#runFrom").validate({
            rules: {
                type: {
                    required: true
                },
                account_type: {
                    min:1
                },
                account_sys_type: {
                    min:1
                },
                money:{
                    required: true,
                    number:true,
                    isMoney:true
                },
                date:{
                    dateISO:true
                }
            },
            messages: {
                account_type: {
                  /*  required: icon + "{{ trans('account\save.run.validate.name_required') }}",*/
                    min: icon + "{{ trans('account\save.run.validate.name_min') }}"
                },
                account_sys_type: {
                    /*required: icon + "{{ trans('account\save.run.validate.name_required') }}",*/
                    min: icon + "{{ trans('account\save.run.validate.name_min') }}"
                },
                type: {
                    required: icon + "{{ trans('account\save.run.validate.status') }}"
                },
                money:{
                    required: icon + "{{ trans('account\save.run.validate.money_required') }}",
                    number: icon + "{{ trans('account\save.run.validate.money_number') }}"
                },
                date: {
                    dateISO: icon + "{{ trans('account\save.run.validate.date') }}"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/account/run/create') }}",
                    dataType: 'json',
                    cache: false,
                    data: $('#runFrom').serialize(),
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
        $('input:radio').click(function () {
            getselect();
        });
        $("#select_name").click(function(){
            if($(this).find('option:selected').attr('data-sys')==1){
               $(this).attr('name','account_sys_type')
            }else{
                $(this).attr('name','account_type')
            }
        });
        function getselect(){
            status=$('input:radio:checked').val();
            $.ajax({
                type: 'POST',
                url: '/account/type',
                data: 'status='+status,
                success: function (datas) {
                    var obj = eval ("(" + datas + ")");
                    var str= '<option value="0" selected="selected">请选择</option>';
                    $.each(obj['user'],function(n,data){
                        str+= '<option data-sys="0" value="'+data.id+'">'+data.name+'</option>';
                    });
                        str+='<option disabled="disabled" style="background-color: #a9a9a9">系统类型</option>';
                    $.each(obj['sys'],function(n,data){
                        str+= '<option data-sys="1" value="'+data.id+'">'+data.name+'</option>';
                    });
                    $('#select_name option').remove();
                    $('#select_name').append(str);
                }
            });
        }





    </script>
@endsection