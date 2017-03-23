@extends($cfg_style.'.layouts.master')
@section('title',$cfg_company.'_'.$cfg_webname)
@section('content')
    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="AccountProject active "  data-load="1"  data-tabNum="1">
                            <a data-toggle="tab" href="#tab-1"  aria-expanded="true">{{ trans('account\fields.salary.integralSalary') }}</a>
                        </li>
                        <li class="AccountProject"   data-load="0" data-url="/account/salary/reward" data-id="{{$user_id}}"  data-month="{{$month}}"  data-tabNum="2">
                            <a data-toggle="tab" href="#tab-2" aria-expanded="true">{{ trans('account\fields.salary.reward') }}</a>
                        </li>
                        <li class="AccountProject"   data-load="0" data-url="/account/salary/deduct" data-id="{{$user_id}}" data-month="{{$month}}"  data-tabNum="3">
                            <a data-toggle="tab" href="#tab-3" aria-expanded="true">{{ trans('account\fields.salary.deduct') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="12">
                                    <thead>
                                    <tr>
                                        <th >{{ trans('account\fields.bonus.type')}}</th>
                                        <th >{{ trans('account\fields.bonus.projectName') }}</th>
                                        <th >{{ trans('account\fields.bonus.price') }}</th>
                                        <th >{{ trans('account\fields.bonus.bonus') }}</th>
                                        <th >{{ trans('account\fields.bonus.integral') }}</th>
                                        <th >{{ trans('account\fields.bonus.salary') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>@if($data->type==1){{ trans('account\fields.bonus.typeProject')}}@elseif($data->type==2){{ trans('account\fields.bonus.typeIntegral')}}@endif</td>
                                            <td>{{ $data->project_name }}</td>
                                            <td>{{ $data->price }}</td>
                                            <td>{{ $data->bonus }}</td>
                                            <td>{{ $data->integral }}</td>
                                            <td>{{ $data->salary }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="12">
                                    <thead>
                                    <tr>
                                        <th >{{ trans('account\fields.salaryReward.money')}}</th>
                                        <th >{{ trans('account\fields.salaryReward.content') }}</th>
                                        <th >{{ trans('account\fields.salaryReward.examine') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="panel-body">
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="12">
                                    <thead>
                                    <tr>
                                        <th >{{ trans('account\fields.salaryReward.money')}}</th>
                                        <th >{{ trans('account\fields.salaryReward.content') }}</th>
                                        <th >{{ trans('account\fields.salaryReward.examine') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    </body>

@endsection
@section('self_js')
    <script>
        $('.AccountProject').click(function(){
            var object=$(this);
            var load=$(object).attr('data-load');
            var userid = $(this).attr('data-id');
            var month = $(this).attr('data-month');
            var dataUrl=$(object).attr('data-url');
            var tabNum=$(object).attr('data-tabNum');
            if(load==0){
                $.ajax({
                    type:'POST',
                    url:dataUrl,
                    data:'id='+userid+'&month='+month,
                    success:function(data){
                        $(object).attr('data-load',1);
                        var htmlObj=$("#tab-"+tabNum);
                        var obj=eval(data);
                        var str='';
                        $.each(obj,function(n,value) {
                            str+='<tr><td>'+value['money']+'</td><td>'+value['content']+'</td><td>'+value['name']+'</td></tr>';
                        });
                        $(htmlObj).find('tbody').html(str);
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







    </script>
@endsection