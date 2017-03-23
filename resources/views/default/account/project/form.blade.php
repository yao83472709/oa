{{--项目名称 --}}
<div class="form-group price_range">
    {!! Form::label('',trans('account\fields.project.form.projectName'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('',null,['id'=>'project_name_dis','class'=>'form-control','disabled'=>'disabled']) !!}
        {!! Form::text('project_name',null,['id'=>'project_name','class'=>'form-control','style'=>'display:none']) !!}
    </div>
</div>
{{--合同编号 --}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('agreement_number',trans('account\fields.project.form.agreement_number'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('',null,['id'=>'agreement_number_dis','class'=>'form-control','disabled'=>'disabled']) !!}
        {!! Form::text('agreement_number',null,['id'=>'agreement_number','class'=>'form-control','style'=>'display:none']) !!}
    </div>
</div>

{{--成交价--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('total_price',trans('account\fields.project.form.total_price'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('',null,['id'=>'total_price_dis','class'=>'form-control','disabled'=>'disabled']) !!}
        {!! Form::text('total_price',null,['id'=>'total_price','class'=>'form-control','style'=>'display:none']) !!}
    </div>
</div>

{{--付款比例--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('payment_ratio',trans('account\fields.project.form.payment_ratio'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('',null,['id'=>'payment_ratio_dis','class'=>'form-control','disabled'=>'disabled']) !!}
        {!! Form::text('payment_ratio',null,['id'=>'payment_ratio','class'=>'form-control','style'=>'display:none']) !!}
    </div>
</div>

{{--付款账期--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('stagestr',trans('account\fields.project.form.stage'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('',null,['id'=>'stage_dis','class'=>'form-control','disabled'=>'disabled']) !!}
        {!! Form::text('stage',null,['id'=>'stage','class'=>'form-control','style'=>'display:none']) !!}
    </div>
</div>

{{--付款金额--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('price',trans('account\fields.project.form.price'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('',null,['id'=>'price_dis','class'=>'form-control','disabled'=>'disabled']) !!}
        {!! Form::text('price',null,['id'=>'price','class'=>'form-control','style'=>'display:none']) !!}
    </div>
</div>

{{--付款时间--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('price_time',trans('account\fields.project.form.time'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('price_time',null,['id'=>'price_time','class'=>'form-control']) !!}
    </div>
</div>

{{--确定收款--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('examine',trans('account\fields.project.form.examine'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!!  Form::checkbox('examine', '1', false, array('class' => 'name','id'=>'examine')) !!}
    </div>
</div>

{{--其他隐性数据--}}
<div class="col-sm-10" style="display: none">
    {!! Form::text('company_id',null,['id'=>'company_id','class'=>'form-control']) !!}
    {!! Form::text('project_id',null,['id'=>'project_id','class'=>'form-control']) !!}
    {!! Form::text('user_id',null,['id'=>'user_id','class'=>'form-control']) !!}
    {!! Form::text('price_user_id',null,['id'=>'price_user_id','class'=>'form-control']) !!}
    {!! Form::text('total_stage',null,['id'=>'total_stage','class'=>'form-control']) !!}
</div>

<div class="hr-line-dashed"></div>
<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2" data-id="{{$i}}">
        {!! Form::button(trans('account\save.form.submit'),array('class' => 'btn btn-primary','id'=>'submitButton')) !!}
    </div>
</div>
