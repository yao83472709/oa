@extends($cfg_style.'.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)
    
@section('self_head')
    <link href="/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/css/style.css?v=4.1.0" rel="stylesheet">
    <style type="text/css">
        .head{ width: 32px }
        .input-group-addon{background-color:none;padding:0px;border: none;}
        dd, dt{line-height:3;}
        .form-horizontal .checkbox, .form-horizontal .checkbox-inline, .form-horizontal .radio, .form-horizontal .radio-inline{padding-top: 0px;}
        .beplaced{border: 2px solid #ed5565}

 
    </style>
    <script type="text/javascript">
        var departmentMemebers = new Array();
        var departmentMemebersInfo = new Array();
    </script>
@endsection

@section('content')
<body class="gray-bg">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    @if($project->customer_id)
                        @if(Auth::user()->is_salesman || Auth::user()->level() > 2)
                            <li class="active"><a data-toggle="tab" href="#tab" aria-expanded="true"> {{ trans('project/show.business')}} </a></li>
                        @else 
                            <li><a data-toggle="tab" href="#tab" aria-expanded="false"> {{ trans('project/show.business')}} </a></li>
                        @endif
                        
                    @endif
                    @foreach($departments as $department)
                        @if(Auth::user()->department_id == $department->id)
                        <li class="active"><a data-toggle="tab" href="#tab-{{ $department->id }}" aria-expanded="true"> {{ $department->alias }} </a></li>
                        @else 
                        <li><a data-toggle="tab" href="#tab-{{ $department->id }}" aria-expanded="false"> {{ $department->alias }} </a></li>
                        @endif
                    @endforeach
                </ul>
                <div class="tab-content">
                    <!--业务情况 开始-->
                    @if($project->customer_id)
                    <div id="tab" class="tab-pane @if(Auth::user()->is_salesman || Auth::user()->level() > 2) active @endif">
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <dl class="dl-horizontal">                                
                                    <dt>{{ trans('project/fields.name') }}：</dt>
                                    <dd>{{ $project->name }}</dd>
                                    <dt>{{ trans('customer/fields.developer') }}：</dt>
                                    <dd>
                                    @if($customer->developer)
                                        <a title="{{ $customer->developer->name }}">
                                            <img src="{{ $customer->developer->head_portrait }}" class="img-circle head" alt="{{ $customer->developer->name }}">
                                        </a>
                                    @endif
                                    </dd>
                                    <dt>{{ trans('customer/fields.salesman') }}：</dt>
                                    <dd>
                                    @if($customer->salesman)
                                        <a title="{{ $customer->salesman->name }}">
                                            <img src="{{ $customer->salesman->head_portrait }}" class="img-circle head" alt="{{ $customer->salesman->name }}">
                                        </a>
                                    @else
                                        <span class="label label-warning">{{ trans('customer/list.not_assigned') }}</span>
                                    @endif
                                    </dd>
                                    <dt>{{ trans('project/fields.deal_price') }}：</dt>
                                    <dd>{{ $project->deal_price }}</dd>
                                    <dt>{{ trans('project/fields.bonus') }}：</dt>
                                    <dd>{{ $project->bonus }}%</dd>
                                </dl>
                            </div>
                            <div class="col-sm-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ trans('customer/fields.company') }}：</dt>
                                    <dd>{{ $customer->company }}</dd>
                                    <dt>{{ trans('customer/fields.business_type') }}：</dt>
                                    <dd>{{ $customer->business_type }}</dd>
                                    <dt>{{ trans('project/fields.is_record') }}：</dt>
                                    <dd>{!! trans('project/fields.is_record_val.'.$project->is_record) !!}</dd>
                                    <dt>{{ trans('project/fields.record_file') }}：</dt>
                                    <dd>
                                        @if($project->record_file)
                                            <a href="{{ url('download/record/'.$project->id) }}">{{ trans('common.download') }}</a>
                                        @else
                                            {!! trans('common.no_data') !!}
                                        @endif
                                    </dd>
                                    <dt>{{ trans('project/fields.relevant_file') }}：</dt>
                                    <dd>
                                        @if($project->relevant_file)
                                            <a href="{{ url('download/relevant/'.$project->id) }}">{{ trans('common.download') }}</a>
                                        @else
                                            {!! trans('common.no_data') !!}
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-sm-12">
                                <h3>{{ trans('project/fields.description') }}：</h3>
                                <p>
                                    @if($project->description)
                                        {{ $project->description }}
                                    @else
                                        {!! trans('common.no_data') !!}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!--业务情况 结束-->

                    @foreach($departments as $department)
                    <div id="tab-{{ $department->id }}" class="tab-pane @if(Auth::user()->department_id == $department->id) active @endif">
                    @if($department->allow)
                    {!! Form::open(['url'=>'','class'=>'form-horizontal','id'=>'departmentForm_'.$department->id]) !!}
                    @endif
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ trans('project/vice/fields.member') }}：</dt>
                                    <dd>
                                    @if($department->allow)
                                    <button class="btn btn-white btn-sm addmember" type="button" data-toggle="modal" data-target="#members" data-id="{{ $department->id }}"><i class="fa fa-plus"></i></button>
                                    @endif
                                    @if($department->members)
                                        @foreach($department->members as $member)
                                        <a title="{{ $member->name }}" @if($department->allow) class="edit_member" data-id="{{ $member->pmid }}" @endif>
                                            <img src="{{ $member->head_portrait }}" class="img-circle head @if($member->bereplace_id) beplaced @endif" alt="{{ $member->name }}">
                                        </a>
                                        @endforeach
                                    @else
                                        {!! trans('project/show.not_assigned') !!}
                                    @endif
                                    </dd>                                    
                                    <dt>{{ trans('project/vice/fields.development_cycle') }}：</dt>
                                    @if($department->allow)
                                    <dd>
                                        <div class="input-daterange input-group col-sm-12 data_5" >
                                            {!! Form::text('start',$department->vice->start,['class'=>'form-control']) !!}
                                            <span class="input-group-addon">{{ trans('common.to') }}</span>
                                            {!! Form::text('end',$department->vice->end,['class'=>'form-control']) !!}
                                        </div>
                                    </dd>
                                    <dt>{{ trans('project/vice/fields.is_examine') }}:</dt>
                                    <dd>
                                        <div class="form-group">
                                            <div class="col-sm-12" id="is_examine{{ $department->id }}">
                                                <div class="radio radio-inline">
                                                    {!! Form::radio('is_examine', 0, true, array('id' => 'inlineRadioa'.$department->id)) !!}
                                                    <label for="inlineRadioa{{ $department->id }}">{{ trans('project/vice/fields.is_examine_val.0') }}</label>
                                                </div>
                                                <div class="radio radio-info radio-inline">
                                                    {!! Form::radio('is_examine', 1, null, array('id' => 'inlineRadiob'.$department->id)) !!}
                                                    <label for="inlineRadiob{{ $department->id }}"> {{ trans('project/vice/fields.is_examine_val.1') }} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </dd>
                                    @else
                                    <dd>{{ $department->vice->start_time }} - {{ $department->vice->end_time }}</dd>
                                    @endif
                                    @if($department->vice->is_examine)              
                                    <dt>{{ trans('project/vice/fields.examine') }}：</dt>
                                    <dd>{{ $department->vice->examine_time }}</dd>
                                    @endif
                                    <dt>{{ trans('project/vice/fields.is_start') }}：</dt>
                                    <dd>
                                    @if($department->vice->is_start)    
                                        {!! trans('project/vice/fields.is_start_val') !!}
                                    @else
                                        <label class="i-checks" id="is_start{{ $department->id }}">
                                            {!! Form::checkbox('is_start', 1); !!}
                                        </label>
                                    @endif
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-sm-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ trans('project/vice/fields.leader') }}：</dt>
                                    <dd>
                                        @if($department->allow)
                                        <button class="btn btn-white btn-sm addleader" type="button" data-toggle="modal" data-target="#leader" data-id="{{ $department->id }}"><i class="fa fa-edit"></i></button>
                                        @endif
                                        @if($department->vice->leader)
                                        <a title="{{ $department->vice->leader->name }}" class="edit_member">
                                            <img src="{{ $department->vice->leader->head_portrait }}" class="img-circle head" alt="{{ $department->vice->leader->name }}">
                                        </a>
                                        @else
                                            {!! trans('project/show.not_assigned') !!}
                                        @endif
                                    </dd>
                                    <script type="text/javascript">
                                        @if($department->json_members)
                                            departmentMemebers[{{ $department->id }}] = {{ $department->json_members }}
                                        @endif

                                        @if($department->josn_current_members)
                                            departmentMemebersInfo[{{ $department->id }}] = {!! $department->josn_current_members !!}
                                        @endif
                                    </script>
                                    @if($department->vice->is_examine)
                                    <dt>{{ trans('project/vice/fields.actual_cycle') }}：</dt>
                                    <dd>
                                        {{ $department->vice->true_start_time }} - {{ $department->vice->true_end_time }}
                                    </dd>
                                    @endif

                                    @if($department->allow_download)
                                    <dt>{{ $department->alias.trans('project/vice/fields.file') }}：</dt>
                                        @if($department->allow)
                                        <dd>                                        
                                            <div id="file-pretty">
                                                {!! Form::file('project_'.$department->id,null,['class'=>'form-control','id'=>'record']) !!}
                                            </div>
                                        </dd>
                                        @endif
                                        @if($department->vice->project_file)
                                        <dd>
                                            <a href="{{ url('download/project/'.$project->id.'/'.$department->id) }}">{{ trans('common.download') }}</a>
                                        </dd>
                                        @else
                                        <dd>{!! trans('common.no_data') !!}</dd>
                                        @endif
                                    @endif

                                    <dt>{{ trans('project/vice/fields.grade') }}：</dt>
                                    <dd>
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                            @foreach($grades as $key => $val)
                                                <div class="radio radio-info radio-inline">
                                                    {!! Form::radio('grade_id', $key, ($department->vice->grade_id == $key)? true: null, array('id' => 'inlineRadioc'.$department->id.$key)) !!}
                                                    <label for="inlineRadioc{{ $department->id.$key }}">{{ $val }}</label>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                            @if($department->vice->description)
                            <div class="col-sm-12">
                                <h3 class="col-sm-2">{{ trans('project/vice/fields.description') }}：</h3>
                                @if($department->allow)
                                <div class="col-sm-10 m-b">
                                {!! Form::textarea('description',$department->vice->description,['class'=>'form-control','rows'=>2]) !!}
                                </div>
                                @else
                                <p>{{ $department->vice->description }}</p>
                                @endif
                            </div>
                            @endif
                    @if($department->allow)
                            {!! Form::hidden('project_file',$department->vice->project_file,['id'=>'project_'.$department->id.'file']) !!}
                            {!! Form::hidden('project_file_suffix',$department->vice->project_file_suffix,['id'=>'project_'.$department->id.'file_suffix']) !!}
                            {!! Form::hidden('vice_id',$department->vice->id,['id'=>'vice_id']) !!}
                            {!! Form::hidden('company_id',Auth::user()->company_id,['id'=>'company_id']) !!}
                            {!! Form::hidden('make_id',Auth::user()->id,['id'=>'company_id']) !!}
                            {!! Form::hidden('project_id',$project->id,['id'=>'project_id']) !!}
                            {!! Form::hidden('department_id',$department->id,['id'=>'department_id']) !!}
                            <div class="ibox-content">
                                <div class="text-center">
                                    <a class="btn btn-primary department_submit" dada-id="{{ $department->id }}">{{ trans('common.submit') }}</a>
                                </div>
                            </div>
                    {!! Form::close() !!}
                    @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!--项目成员 开始-->
                <div class="modal inmodal fade" id="members" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h6 class="modal-title">{{ trans('project/show.add_member') }}</h6>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['url'=>'','class'=>'form-horizontal m-t','id'=>'membersForm']) !!}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          {!! Form::label(trans('project/show.all_members'),null,['class'=>'col-sm-3 control-label']) !!}
                                          <div class="col-sm-9" id="allMembers">

                                          </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::hidden('project_id',$project->id,['id'=>'project_id']) !!}
                                {!! Form::hidden('company_id',Auth::user()->company_id,['id'=>'company_id']) !!}
                                {!! Form::hidden('department_id',null,['id'=>'member_department_id']) !!}
                                {!! Form::hidden('make_id',Auth::user()->id,['id'=>'make_id']) !!}
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('customer/customersdynamic/list.close') }}</button>
                                <button type="button" class="btn btn-primary" id="members_submit">{{ trans('customer/customersdynamic/list.yes') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--项目成员 结束-->

                <!--小组组长 开始-->
                <div class="modal inmodal fade" id="leader" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h6 class="modal-title">{{ trans('project/show.add_leader') }}</h6>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['url'=>'','class'=>'form-horizontal m-t','id'=>'leaderForm']) !!}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {!! Form::label(trans('project/show.current_members'),null,['class'=>'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9" id="projectMembers">
 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::hidden('replaced_id',null,['id'=>'replaced_id']) !!}
                                {!! Form::hidden('project_id',$project->id,['id'=>'project_id']) !!}
                                {!! Form::hidden('company_id',Auth::user()->company_id,['id'=>'company_id']) !!}
                                {!! Form::hidden('department_id',null,['id'=>'leader_department_id']) !!}
                                {!! Form::hidden('make_id',Auth::user()->id,['id'=>'make_id']) !!}
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('customer/customersdynamic/list.close') }}</button>
                                <button type="button" class="btn btn-primary" id="leader_submit">{{ trans('customer/customersdynamic/list.yes') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--小组组长 结束-->
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
<!-- Data picker -->
<script src="/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- Input Mask-->
<script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<!-- Prettyfile -->
<script src="/js/plugins/prettyfile/bootstrap-prettyfile.js"></script>
<script src="/js/ajaxfileupload.js"></script>
<script>
$(function () {
    $('.data_5').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    $( '#file-pretty input[type="file"]' ).prettyFile();

    /*添加成员*/
    $('.addmember').click(function () {
        var department_id = $(this).attr('data-id');
        $('#member_department_id').val(department_id);
        var nodes= '';
        $.post(
            "{{ url('users/getdepartmentusers') }}",
            {company_id:{{ Auth::user()->company_id }}, 'department_id':department_id, _token:"{{ csrf_token() }}"}, 
            function(result){
                $.each(result,function(n,value) {
                    if($.inArray(value.id,departmentMemebers[department_id]) >= 0){
                       nodes += "<label class='checkbox-inline i-checks'><input type='checkbox' checked='true' value='"+value.id+"'' name='mids[]'><img src='"+value.head_portrait+"' class='img-circle head' alt='"+value.name+"''>"+value.name+"</label>";
                    }else{
                        nodes += "<label class='checkbox-inline i-checks'><input type='checkbox' value='"+value.id+"'' name='mids[]'><img src='"+value.head_portrait+"' class='img-circle head' alt='"+value.name+"''>"+value.name+"</label>";
                    }
                    
                });
                $('#allMembers').html(nodes);

                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
          }
        );
    })

    $('#members_submit').click(function () {
        $.ajax({
            type: "POST",
            url: "{{ url('projects/members/store') }}",
            dataType: 'json',
            data: $("#membersForm").serialize(),
            async: false,
            success: function(data) {
                layer.msg(data.message, {icon: 1});
                setTimeout(function () {
                    location.reload(); // 父页面刷新
                },1500); 
                
            },
            error: function(xhr) {
                $.each(xhr.responseJSON,function(n,value) {   
                    layer.msg(value+'', {icon: 7});
                });  
            }
        });
    })

    /*添加组长*/
    $('.addleader').click(function () {
        var department_id = $(this).attr('data-id'); 
        $('#leader_department_id').val(department_id);
        var nodes= '';       
        if(departmentMemebersInfo[department_id]) {
            $.each(departmentMemebersInfo[department_id],function(n,value) {
                if(value.is_leader) {
                    $('#replaced_id').val(value.id)
                     nodes += "<div class='radio radio-info radio-inline'><input checked='true' id='inlineRadio"+value.id+"' name='leader' value='"+value.id+"' type='radio'><label for='inlineRadio"+value.id+"'><img src='"+value.head_portrait+"' class='img-circle head' alt='"+value.name+"''>"+value.name+" </label></div>";
                }else{
                     nodes += "<div class='radio radio-info radio-inline'><input id='inlineRadio"+value.id+"' name='leader' value='"+value.id+"' type='radio'><label for='inlineRadio"+value.id+"'><img src='"+value.head_portrait+"' class='img-circle head' alt='"+value.name+"''>"+value.name+" </label></div>";
                }
            });
            
        }else{
            nodes += '{!! trans('project/show.no_members') !!}';
        }
        $('#projectMembers').html(nodes);
    })

    $('#leader_submit').click(function () {
        $.ajax({
            type: "POST",
            url: "{{ url('projects/members/leader') }}",
            dataType: 'json',
            data: $("#leaderForm").serialize(),
            async: false,
            success: function(data) {
                layer.msg(data.message, {icon: 1});
                setTimeout(function () {
                    location.reload(); // 父页面刷新
                },1500);
            },
            error: function(xhr) {
                $.each(xhr.responseJSON,function(n,value) {
                    layer.msg(value+'', {icon: 7});
                });  
            }
        });
    })

    /*编辑小组成员*/
    $('.edit_member').click(function () {
        var member_id = $(this).attr('data-id');
        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
        parent.layer.full(index); 
        layer.open({
            type: 2,
            title: "{{ trans('project/list.edit_member') }}",
            shadeClose: true,
            shade: false,
            maxmin: true, //开启最大化最小化按钮
            area: ['850px', '520px'],
            offset: '8%',
            shift: 2,
            content: ["/projectsmember/"+member_id+"/edit","no"],
        });
    })

    var icon = "<i class='fa fa-times-circle'></i> ";
    /*提交项目数据*/
    function ajaxProjectForm(data) {
        $.ajax({
            type: "POST",
            url: "{{ url('projects/vice/update') }}",
            dataType: 'json',
            cache: false,
            data: data,
            async: false,
            success: function(data) {
                if(data.status) {
                    layer.msg(data.message, {icon: 7});
                    return false;
                }
                layer.msg(data.message, {icon: 1});
                location.reload(); 
            },
            error: function(xhr) {
                $.each(xhr.responseJSON,function(n,value) {   
                    layer.msg(value+'', {icon: 7});
                });  
            }
        });
    }
    /*保存相关部门项目信息*/
    $('.department_submit').click(function () {
        var department_id = $(this).attr('dada-id')
        /*上传项目文件*/            
        if($('input[name="project_' + department_id +'"]').val()) {
            $('input[name="project_' + department_id +'"]').attr('id','project_' + department_id)
            $.ajaxFileUpload({
                url: "{{ url('files/upload') }}",
                type: 'post',
                secureuri: false,
                data: {company_id:$('#company_id').val(), type:2, fileName:"{{ $project->number }}", department_id:department_id, _token:"{{ csrf_token() }}"},
                fileElementId: 'project_' + department_id,
                dataType: 'json',
                async: false,
                success: function (data) {
                    $('#project_'+department_id+'file_suffix').val(data.value.suffix)
                    $('#project_'+department_id+'file').val(data.value.path);
                },
                error: function (xhr) {
                    $.each(xhr.responseJSON,function(n,value) {   
                        layer.msg(value+'', {icon: 7});
                    });
                }
            });
        }
        var confirm_msg = '';
        if($('#is_start'+department_id+' input[name="is_start"]:checked').val() == 1){
            confirm_msg += "{!! trans('project/save.start_confirm') !!}";
        }
        if($('#is_examine'+department_id+' input[name="is_examine"]:checked').val() == 1){
            confirm_msg += "{!! trans('project/save.submit_confirm') !!}";
        }
        if(confirm_msg){
            layer.confirm(confirm_msg, {
                offset: '25%',
                time: 20000, //20s后自动关闭
                btn: ["{{ trans('common.yes') }}", "{{ trans('common.no') }}"]
              },function () {
                    ajaxProjectForm($("#departmentForm_"+department_id).serialize());
              },function (index) {
                  layer.close(index);
            });
        }else{
            ajaxProjectForm($("#departmentForm_"+department_id).serialize());
        }
        return false
    })
});
</script>
@endsection