{{--收支类型--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.run.form.status'), array('class'=>'col-sm-2 control-label')) !!}
    {!! Form::label('status_in',trans('account\fields.run.form.status_in'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-3">
        {!! Form::radio('type', '1', true, array('class' => 'name','id'=>'status_in','disabled'=>'disabled')) !!};
    </div>
    {!! Form::label('status_out',trans('account\fields.run.form.status_out'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-3">
        {!! Form::radio('type', '2', false, array('class' => 'name','id'=>'status_out','disabled'=>'disabled')) !!};
    </div>
</div>
{{--种类名称 --}}
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.run.form.runtype_name'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::select('account_type',array(trans('account\fields.run.form.select_default')), '0',array('id'=>'select_name','class'=>'form-control','disabled'=>'disabled')) !!}
    </div>
</div>
{{--付款金额--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('money',trans('account\fields.run.form.money'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('money',null,array('id'=>'money','class'=>'form-control','disabled'=>'disabled')) !!}
    </div>
</div>
{{--摘要--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('description',trans('account\fields.run.description'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::textarea('description',null,array('id'=>'description','class'=>'form-control')) !!}
    </div>
</div>

{{--时间--}}

<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('date',trans('account\fields.run.time'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('date',null,array('id'=>'date','class'=>'form-control','disabled'=>'disabled')) !!}
    </div>
</div>


<div class="hr-line-dashed"></div>
<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        <button class="btn btn-primary">{{ trans('save.form.submit') }}</button>
    </div>
</div>
