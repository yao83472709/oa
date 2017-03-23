@extends($cfg_style.'.layouts.master')
@section('title',$cfg_company.'_'.$cfg_webname)
@section('content')
    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                @foreach($datas as $data)
                                    <div style="display: none" id="finishid">{{$data->finish}}</div>
                                    @if($data->finish!=1)
                                        @for ($i=0;$i<=$data->stage;$i++)
                                            <li class="@if($i<$data->stage)AccountProject @endif @if($i==$data->stage)active @endif"  @if($i==$data->stage)  data-url="/account/project/getprojectid" @else data-url="/account/project/getAccountProject" @endif data-id="{{$data->id}}"  data-stage="{{$i+1}}" data-load="0" >
                                                <a data-toggle="tab" href="#tab-{{$i}}" aria-expanded="true"> 第{{$i+1}}期</a>
                                            </li>
                                        @endfor
                                    @else
                                        @for ($i=0;$i<$data->stage;$i++)
                                            <li class="AccountProject @if($i==$data->stage-1)active @endif"  @if($i==$data->stage)  data-url="/account/project/getprojectid" @else data-url="/account/project/getAccountProject" @endif data-id="{{$data->id}}"  data-stage="{{$i+1}}" data-load="0" >
                                                <a data-toggle="tab" href="#tab-{{$i}}" aria-expanded="true"> 第{{$i+1}}期</a>
                                            </li>
                                        @endfor
                                    @endif
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($datas as $key=>$data)
                                    @if($data->finish!=1)
                                        @for ($i=0;$i<=$data->stage;$i++)
                                            @if($i==$data->stage )
                                                <div id="tab-{{$i}}" class="tab-pane @if($i==$data->stage)active @endif">
                                                    <div class="panel-body" id="projectid_{{$i}}">
                                                        {!! Form::open(array('class'=>'form-horizontal m-t')) !!}
                                                        @include($cfg_style.'.account.project.form')
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            @else
                                                <div id="tab-{{$i}}" class="tab-pane">
                                                    <div class="panel-body" id="projectid_{{$i}}">
                                                        {!! Form::open(array('class'=>'form-horizontal m-t',)) !!}
                                                        @include($cfg_style.'.account.project.form1')
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            @endif
                                        @endfor
                                    @else
                                        @for ($i=0;$i<$data->stage;$i++)
                                            <div id="tab-{{$i}}" class="tab-pane @if($i==$data->stage-1)active @endif">
                                                <div class="panel-body" id="projectid_{{$i}}">
                                                    {!! Form::open(array('class'=>'form-horizontal m-t',)) !!}
                                                    @include($cfg_style.'.account.project.form1')
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        @endfor
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
@endsection

@section('self_js')
    <script>
        var finishid=$('#finishid').html();
        if(finishid==0){
            $.ajax({
                type:'POST',
                url:'/account/project/getprojectid',
                data:'id='+1,
                success:function(data){
                    var obj=eval(data);
                    $('#agreement_number').val(obj[0]['agreement_number']);
                    $('#agreement_number_dis').val(obj[0]['agreement_number']);
                    $('#project_name').val(obj[0]['project_name']);
                    $('#project_name_dis').val(obj[0]['project_name']);
                    $('#total_price').val(obj[0]['total_price']);
                    $('#total_price_dis').val(obj[0]['total_price']);
                    $('#payment_ratio').val(obj[0]['payment_ratio']);
                    $('#payment_ratio_dis').val(obj[0]['payment_ratio']);
                    $('#stage').val(obj[0]['stage']);
                    $('#stage_dis').val(obj[0]['stagestr']);
                    $('#price').val(obj[0]['stage_price']);
                    $('#price_dis').val(obj[0]['stage_price']);
                    $('#company_id').val(obj[0]['company_id']);
                    $('#project_id').val(obj[0]['project_id']);
                    $('#user_id').val(obj[0]['user_id']);
                    $('#price_user_id').val(obj[0]['price_user_id']);
                    $('#total_stage').val(obj[0]['total_stage']);
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
        else{
            var object=$('.AccountProject:last');
            var load= $(object).attr('data-load');
            var Projectid= $(object).attr('data-id');
            var dataUrl= $(object).attr('data-url');
            var dataStage= $(object).attr('data-stage');
            var projectid=dataStage-1;

            $.ajax({
                type:'POST',
                url:dataUrl,
                data:'id='+Projectid+'&stage='+dataStage,
                success:function(data){
                    $(object).attr('data-load',1);
                    var htmlObj=$("#projectid_"+projectid);
                    var obj=eval(data);
                    htmlObj.find('input[name="projectName"]').val(obj[0]['project_name']);
                    htmlObj.find('input[name="agreement_number"]').val(obj[0]['agreement_number']);
                    htmlObj.find('input[name="total_price"]').val(obj[0]['total_price']);
                    htmlObj.find('input[name="payment_ratio"]').val(obj[0]['payment_ratio']);
                    htmlObj.find('input[name="stage"]').val(obj[0]['stagestr']);
                    htmlObj.find('input[name="price"]').val(obj[0]['price']);
                    htmlObj.find('input[name="price_time"]').val(obj[0]['price_time']);
                    htmlObj.find('input[name="user_name"]').val(obj[0]['user_name']);
                    htmlObj.find('input[name="examine_time"]').val(obj[0]['created_at']);
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

        $('#submitButton').click(function(){
            if(onsubmitfun()){
                $id=$(this).parent().attr('data-id');
                $.ajax({
                    type: "POST",
                    url: "{{ url('/account/project/create') }}",
                    dataType: 'json',
                    cache: false,
                    data: $('#projectid_'+$id+" form").serialize(),
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
        $('.AccountProject').click(function(){
           var object=$(this);
           var load=$(object).attr('data-load');
           var Projectid=$(object).attr('data-id');
            var dataUrl=$(object).attr('data-url');
            var dataStage=$(object).attr('data-stage');
            var projectid=dataStage-1;
            if(load==0){
                $.ajax({
                    type:'POST',
                    url:dataUrl,
                    data:'id='+Projectid+'&stage='+dataStage,
                    success:function(data){
                        $(object).attr('data-load',1);
                        var htmlObj=$("#projectid_"+projectid);
                        var obj=eval(data);
                        htmlObj.find('input[name="projectName"]').val(obj[0]['project_name']);
                        htmlObj.find('input[name="agreement_number"]').val(obj[0]['agreement_number']);
                        htmlObj.find('input[name="total_price"]').val(obj[0]['total_price']);
                        htmlObj.find('input[name="payment_ratio"]').val(obj[0]['payment_ratio']);
                        htmlObj.find('input[name="stage"]').val(obj[0]['stagestr']);
                        htmlObj.find('input[name="price"]').val(obj[0]['price']);
                        htmlObj.find('input[name="price_time"]').val(obj[0]['price_time']);
                        htmlObj.find('input[name="user_name"]').val(obj[0]['user_name']);
                        htmlObj.find('input[name="examine_time"]').val(obj[0]['created_at']);
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

        });
        function onsubmitfun(){

            if($('#price_time').val()==''){
                layer.msg('{{trans('account\fields.project.form.time')}}{{trans('account\save.msg.nonull')}}', {icon: 2});
                return false;
            }

            else if(!$('#examine').is(':checked')){
                layer.msg('{{trans('account\fields.project.form.examine')}}{{trans('account\save.msg.nonull')}}',{icon: 2})
                return false;
            }
            else return true;
            return false;
        }






    </script>
@endsection