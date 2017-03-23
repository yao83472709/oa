		<div class="form-group">
			{!! Form::label(trans('project/fields.name'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('name',null,['class'=>'form-control']) !!}
			</div>
		</div>
		
		<div class="form-group">
            {!! Form::label(trans('project/fields.departments'),null,['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-9">
            @foreach($departments as $department)
                <label class="checkbox-inline i-checks">
                	<input type="checkbox" name="departments[]" value="{{ $department->id }}" @if($department->checked) checked="true" @endif >{{ $department->name }} 
                </label>
            @endforeach
            </div>
        </div>

		<div class="form-group" id="data_5">
            {!! Form::label(trans('project/fields.development_cycle'),null,['class'=>'col-sm-2 control-label']) !!}
            <div class="input-daterange input-group col-sm-10" id="datepicker">
                {!! Form::text('start',null,['class'=>'form-control']) !!}
                <span class="input-group-addon">{{ trans('common.to') }}</span>
                {!! Form::text('end',null,['class'=>'form-control']) !!}
            </div>
        </div>

		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('project/fields.deal_price'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('deal_price',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('project/fields.bonus'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('bonus',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
            {!! Form::label(trans('project/fields.payment_ratio'),null,['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('payment_ratio','3-3-4',['class'=>'form-control','data-mask'=>'9-9-9']) !!}
            </div>
        </div>

		<div class="form-group ">
			{!! Form::label(trans('project/fields.is_invoice'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				<div class="radio radio-inline">
					{!! Form::radio('is_invoice', 0, true, array('id' => 'inlineRadio1')) !!}
	                <label for="inlineRadio1">{{ trans('project/fields.is_invoice_val.0') }}</label>
	            </div>
				<div class="radio radio-info radio-inline">
	                {!! Form::radio('is_invoice', 1, null, array('id' => 'inlineRadio2')) !!}
	                <label for="inlineRadio2"> {{ trans('project/fields.is_invoice_val.1') }} </label>
	            </div>
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group ">
			{!! Form::label(trans('project/fields.is_record'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				<div class="radio radio-inline">
					{!! Form::radio('is_record', 0, true, array('id' => 'inlineRadio3')) !!}
	                <label for="inlineRadio3">{{ trans('project/fields.cis_record_val.0') }}</label>
	            </div>
				<div class="radio radio-info radio-inline">
	                {!! Form::radio('is_record', 1, null, array('id' => 'inlineRadio4')) !!}
	                <label for="inlineRadio4"> {{ trans('project/fields.cis_record_val.1') }} </label>
	            </div>
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('project/fields.record_file'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
	            <div id="file-pretty">
	                {!! Form::file('record',null,['class'=>'form-control','id'=>'record']) !!}
	            </div>
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('project/fields.relevant_file'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
	            <div id="file-pretty">
	                {!! Form::file('relevant',null,['class'=>'form-control','id'=>'record']) !!}
	            </div>
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group ">
			{!! Form::label(trans('project/fields.description'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::textarea('description',null,['class'=>'form-control','rows'=>3]) !!}
			</div>
		</div>
		
		{!! Form::hidden('company_id',Auth::user()->company_id,['id'=>'company_id']) !!}
		{!! Form::hidden('make_id',Auth::user()->id,['id'=>'make_id']) !!}
		{!! Form::hidden('record_file',null,['id'=>'record_file']) !!}
		{!! Form::hidden('record_file_suffix',null,['id'=>'record_file_suffix']) !!}
		{!! Form::hidden('relevant_file',null,['id'=>'relevant_file']) !!}
		{!! Form::hidden('relevant_file_suffix',null,['id'=>'relevant_file_suffix']) !!}
		<div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <button class="btn btn-primary">{{ trans('project/fields.submit') }}</button>
            </div>
        </div>