		<div class="form-group">
			{!! Form::label(trans('role/fields.department'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::select('department_id', $departments,null, array('class' => 'form-control')) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group name">
			{!! Form::label(trans('role/fields.name'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('name',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group description">
			{!! Form::label(trans('role/fields.level'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-3">
			{!! Form::select('level', array(1=>trans('role/fields.levels.1'), 2=>trans('role/fields.levels.2'), 3=>trans('role/fields.levels.3')),null, array('class' => 'form-control')) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group description">
			{!! Form::label(trans('role/fields.status'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-3">
			{!! Form::select('status', array(0=>trans('role/fields.status_val.0'), 1=>trans('role/fields.status_val.1')),null, array('class' => 'form-control')) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group description">
			{!! Form::label(trans('role/fields.description'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::textarea('description',null,['class'=>'form-control','rows'=>2]) !!}
			</div>
		</div>
		
		{!! Form::hidden('company_id',Auth::user()->company_id,['class'=>'company_id']) !!}
		<div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <button class="btn btn-primary">{{ trans('save.form.submit') }}</button>
            </div>
        </div>