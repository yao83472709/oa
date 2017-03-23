{{--项目名称 --}}
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.projectName'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('projectName',null,['class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>
{{--合同编号 --}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.agreement_number'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('agreement_number',null,['class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--成交价--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.total_price'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('total_price',null,['class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--付款比例--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.payment_ratio'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('payment_ratio',null,['class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--付款账期--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.stage'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('stage',null,['class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--付款金额--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.price'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('price',null,['class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--付款时间--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.time'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('price_time',null,['class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>
{{--确认人员--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.examine_user'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('user_name',null,['class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>
{{--确认时间--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.examine_time'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('examine_time',null,['class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>




