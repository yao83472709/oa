@extends('default.layouts.master')

@section('title',$cfg_company.'_'.$cfg_webname)

@section('self_head')
<link href="/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
@endsection

@section('content')

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li @if(session('action') == 'web'|| session('action') == '') class="active" @endif>
                            <a data-toggle="tab" href="#tab-1" aria-expanded="true">{{ trans('sysconfig/list.web') }}</a>
                        </li>
                        <li @if(session('action') == 'core') class="active" @endif>
                            <a data-toggle="tab" href="#tab-2" aria-expanded="false">{{ trans('sysconfig/list.core') }}</a>
                        </li>
                        <li @if(session('action') == 'file') class="active" @endif>
                            <a data-toggle="tab" href="#tab-3" aria-expanded="false">{{ trans('sysconfig/list.file') }}</a>
                        </li>
                        <li @if(session('action') == 'interaction') class="active" @endif>
                            <a data-toggle="tab" href="#tab-4" aria-expanded="false">{{ trans('sysconfig/list.interaction') }}</a>
                        </li>
                        <li @if(session('action') == 'other') class="active" @endif>
                            <a data-toggle="tab" href="#tab-5" aria-expanded="false">{{ trans('sysconfig/list.other') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane @if(session('action') == 'web'|| session('action') == '') active @endif">
                            <div class="col-sm-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
                                    @if($web_configs)
                                        {!! Form::open(['url'=>'sysconfig/update','class'=>'form-horizontal m-t','enctype'=>'multipart/form-data']) !!}
                                        @foreach ($web_configs as $config)
                                            <div class="form-group">
                                                {!! Form::label($config->info,null,['class'=>'col-sm-2 control-label']) !!}
                                                <div class="col-sm-8">
                                                {!! Form::text('data['.$config->id.']',$config->value,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        @endforeach
                                            {!! Form::hidden('company_id',Auth::user()->company_id) !!}
                                            {!! Form::hidden('action','web') !!}
                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button class="btn btn-primary" type="submit">{{ trans('sysconfig/save.submit') }}</button>
                                                </div>
                                            </div>
                                        {!! Form::close() !!}
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane @if(session('action') == 'core') active @endif">
                            <div class="col-sm-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
                                    @if($core_configs)
                                        {!! Form::open(['url'=>'sysconfig/update','class'=>'form-horizontal m-t','enctype'=>'multipart/form-data']) !!}
                                        @foreach ($core_configs as $config)
                                            <div class="form-group">
                                                {!! Form::label($config->info,null,['class'=>'col-sm-2 control-label']) !!}
                                                <div class="col-sm-8">
                                                    {!! Form::text('data['.$config->id.']',$config->value,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        @endforeach
                                            {!! Form::hidden('company_id',Auth::user()->company_id) !!}
                                            {!! Form::hidden('action','core') !!}
                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button class="btn btn-primary" type="submit">{{ trans('sysconfig/save.submit') }}</button>
                                                </div>
                                            </div>
                                        {!! Form::close() !!}
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane @if(session('action') == 'file') active @endif">
                            <div class="col-sm-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
                                    @if($file_configs)
                                        {!! Form::open(['url'=>'sysconfig/update','class'=>'form-horizontal m-t','enctype'=>'multipart/form-data']) !!}
                                        @foreach ($file_configs as $config)
                                            <div class="form-group">
                                                {!! Form::label($config->info,null,['class'=>'col-sm-2 control-label']) !!}
                                                <div class="col-sm-8">
                                                    {!! Form::text('data['.$config->id.']',$config->value,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        @endforeach
                                            {!! Form::hidden('company_id',Auth::user()->company_id) !!}
                                            {!! Form::hidden('action','file') !!}
                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button class="btn btn-primary" type="submit">{{ trans('sysconfig/save.submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-4" class="tab-pane @if(session('action') == 'interaction') active @endif">
                            <div class="col-sm-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
                                    @if($interaction_configs)
                                        {!! Form::open(['url'=>'sysconfig/update','class'=>'form-horizontal m-t','enctype'=>'multipart/form-data']) !!}
                                        @foreach ($interaction_configs as $config)
                                            <div class="form-group">
                                                {!! Form::label($config->info,null,['class'=>'col-sm-2 control-label']) !!}
                                                <div class="col-sm-8">
                                                    {!! Form::text('data['.$config->id.']',$config->value,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        @endforeach
                                            {!! Form::hidden('company_id',Auth::user()->company_id) !!}
                                            {!! Form::hidden('action','interaction') !!}
                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button class="btn btn-primary" type="submit">{{ trans('sysconfig/save.submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-5" class="tab-pane @if(session('action') == 'other') active @endif">
                            <div class="col-sm-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
                                        @if($other_configs)
                                        {!! Form::open(['url'=>'sysconfig/update','class'=>'form-horizontal m-t','enctype'=>'multipart/form-data']) !!}
                                            @foreach ($other_configs as $config)
                                            <div class="form-group">
                                                {!! Form::label($config->info,null,['class'=>'col-sm-2 control-label']) !!}
                                                @if($config->type == 1)
                                                <div class="col-sm-8">
                                                    <div class="radio radio-inline">
                                                        {!! Form::radio('data['.$config->id.']',0,$config->value?null:true, array('id' => 'emailClose'.$config->id)) !!}
                                                        <label for="emailClose{{ $config->id }}">{{ trans('collection.is_email.0') }}</label>
                                                    </div>
                                                    <div class="radio radio-info radio-inline">
                                                        {!! Form::radio('data['.$config->id.']', 1,$config->value?true:null, array('id' => 'emailopen'.$config->id)) !!}
                                                        <label for="emailopen{{ $config->id }}"> {{ trans('collection.is_email.1') }} </label>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="col-sm-8">
                                                    {!! Form::text('data['.$config->id.']',$config->value,['class'=>'form-control']) !!}
                                                </div>
                                                @endif
                                            </div>
                                            @endforeach
                                            {!! Form::hidden('company_id',Auth::user()->company_id) !!}
                                            {!! Form::hidden('action','other') !!}
                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button class="btn btn-primary" type="submit">{{ trans('sysconfig/save.submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                        @endif
                                    </div>
                                </div>
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
<!-- 自定义js -->
<script src="/js/content.js?v=1.0.0"></script>
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<script>
@if(session('result'))
    layer.msg("{{ session('result')['message'] }}", {icon: "{{ session('result')['status'] == 0?1:7}}" });
@endif
$(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    
    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });

});
</script>
@endsection
