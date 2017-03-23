{{--公司id --}}
<div class="form-group price_range" style="display: none">
    {!! Form::text('company_id',null,['id'=>'company_id','class'=>'form-control']) !!}
</div>

{{--种类名称 --}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('runtype_name',trans('account\fields.run.form.runtype_name'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('name',null,['id'=>'runtype_name','class'=>'form-control',]) !!}
    </div>
</div>

{{--收支类型--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.run.form.status'), array('class'=>'col-sm-2 control-label')) !!}
    {!! Form::label('status_in',trans('account\fields.run.form.status_in'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-3">
        {!! Form::radio('status', '1', true, array('class' => 'name','id'=>'status_in')) !!};
    </div>
        {!! Form::label('status_out',trans('account\fields.run.form.status_out'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-3">
         {!! Form::radio('status', '2', false, array('class' => 'name','id'=>'status_out','data-load'=>'0')) !!};
    </div>
</div>

{{--支出系统类型--}}
<div class="hr-line-dashed displaySelect"></div>
<div class="form-group price_range displaySelect" >
    {!! Form::label('',trans('account\fields.run.form.account_sys_type'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::select('account_sys_type',array(trans('account\fields.run.form.select_default')), '0',array('id'=>'select_name','class'=>'form-control')) !!}
    </div>
</div>



<div class="hr-line-dashed"></div>
<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        <button class="btn btn-primary">{{ trans('save.form.submit') }}</button>
    </div>
</div>
