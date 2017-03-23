		<div class="form-group name">
			{!! Form::label(trans('mark/fields.name'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('name',null,['class'=>'form-control']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label(trans('mark/fields.bonus'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('bonus',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group description">
			{!! Form::label(trans('mark/fields.status'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-3">
			{!! Form::select('status', array(0=>trans('common.status_val.0'), 1=>trans('common.status_val.1')),null, array('class' => 'form-control')) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group description">
			{!! Form::label(trans('mark/fields.description'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::textarea('description',null,['class'=>'form-control','rows'=>3]) !!}
			</div>
		</div>
		
		{!! Form::hidden('company_id',Auth::user()->company_id,['class'=>'company_id']) !!}
		<div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <button class="btn btn-primary">{{ trans('common.submit') }}</button>
            </div>
        </div>