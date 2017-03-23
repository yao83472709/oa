{{--合同编号 --}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('agreement_number',trans('fields.account.form.agreement_number'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('agreement_number',null,['id'=>'agreement_number','class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--成交价--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('total_price',trans('fields.account.form.total_price'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('total_price',null,['id'=>'total_price','class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--付款比例--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('payment_ratio',trans('fields.account.form.payment_ratio'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('payment_ratio',null,['id'=>'payment_ratio','class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--付款账期--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('stagestr',trans('fields.account.form.stage'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('stagestr',null,['id'=>'stagestr','class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--付款金额--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('price',trans('fields.account.form.price'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('price',null,['id'=>'price','class'=>'form-control','disabled'=>'disabled']) !!}
    </div>
</div>

{{--付款金额--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('time',trans('fields.account.form.time'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('time',null,['id'=>'time','class'=>'form-control']) !!}
    </div>
</div>



{{--确定收款--}}
<div class="hr-line-dashed"></div>
<div class="form-group price_range">
    {!! Form::label('examine',trans('fields.account.form.examine'), array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!!  Form::checkbox('examine', '1', false, array('class' => 'name')) !!}

    </div>
</div>




<div class="hr-line-dashed"></div>
<div class="form-group">
    <div class="col-sm-4 col-sm-offset-2">
        {!! Form::button(trans('save.form.submit'),array('class' => 'btn btn-primary','id'=>'submitButton')) !!}
    </div>
</div>
