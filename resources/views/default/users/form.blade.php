		<div class="form-group">
			{!! Form::label(trans('user/fields.number'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('number',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('user/fields.username'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('username',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('user/fields.password'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::password('password',['class'=>'form-control password']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('user/fields.confirm_password'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::password('confirm_password',['class'=>'form-control']) !!}
			<span class="help-block m-b-none"><i class="fa fa-info-circle"></i> {{ trans('user/save.comfirm_tip')}}</span>
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('user/fields.name'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('name',null,['class'=>'form-control']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label(trans('user/fields.nickname'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('nickname',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group description">
			{!! Form::label(trans('common.status'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-3">
			{!! Form::select('status', array(0=>trans('user/fields.status.0'), 1=>trans('user/fields.status.1'), 2=>trans('user/fields.status.2')),null, array('class' => 'form-control')) !!}
			</div>
		</div>

		<div class="form-group" id="data_2">
			{!! Form::label(trans('user/fields.created_at'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				<div class="input-group date">
	                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                {!! Form::text('created_at',null,['class'=>'form-control']) !!}
	            </div>
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('user/fields.is_developer'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				<div class="radio radio-inline">
					{!! Form::radio('is_developer', 0, true, array('id' => 'inlineRadio1')) !!}
	                <label for="inlineRadio1">{{ trans('common.option_val.0') }}</label>
	            </div>
				<div class="radio radio-info radio-inline">
	                {!! Form::radio('is_developer', 1, null, array('id' => 'inlineRadio2')) !!}
	                <label for="inlineRadio2">{{ trans('common.option_val.1') }}</label>
	            </div>
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('user/fields.is_salesman'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				<div class="radio radio-inline">
					{!! Form::radio('is_salesman', 0, true, array('id' => 'inlineRadioa')) !!}
	                <label for="inlineRadioa">{{ trans('common.option_val.0') }}</label>
	            </div>
				<div class="radio radio-info radio-inline">
	                {!! Form::radio('is_salesman', 1, null, array('id' => 'inlineRadiob')) !!}
	                <label for="inlineRadiob">{{ trans('common.option_val.1') }}</label>
	            </div>
			</div>
		</div>	

		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('user/fields.department'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::select('department_id', $departments,null, array('class' => 'form-control')) !!}
			</div>
		</div>
		
        <div class="form-group">
        	{!! Form::label(trans('user/fields.power_group'),null,['class'=>'col-sm-2 control-label']) !!}
        	<div class="col-sm-10">
		        <div class="input-group">
		            <select data-placeholder="请选择职位" name="role_id[]" class="chosen-select" multiple style="width:350px;" tabindex="4">
		                @foreach($roles as $role)
		                <option value="{{ $role->id }}" @if($role->selected) selected="selected" @endif hassubinfo="true">{{ $role->name }}</option>
		                @endforeach
		            </select>
		        </div>
		    </div>
    	</div>
		
		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('user/fields.safe_deduct'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('safe_deduct',null,['class'=>'form-control']) !!}
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('user/fields.phone'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('phone',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('user/fields.mobile'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('mobile',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('user/fields.email'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('email',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('user/fields.sex'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				<div class="radio radio-inline">
					{!! Form::radio('sex', 0, true, array('id' => 'inlineRadio3')) !!}
	                <label for="inlineRadio3">{{ trans('user/fields.sex_val.0') }}</label>
	            </div>
				<div class="radio radio-info radio-inline">
	                {!! Form::radio('sex', 1, null, array('id' => 'inlineRadio4')) !!}
	                <label for="inlineRadio4">{{ trans('user/fields.sex_val.1') }}</label>
	            </div>
			</div>
		</div>		

		<div class="form-group">
			{!! Form::label(trans('user/fields.address'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-3">
			{!! Form::select('province', $provinces,null, array('class' => 'form-control')) !!}
			</div>
			
			<div class="col-sm-3">
			{!! Form::select('city', array(),null, array('class' => 'form-control')) !!}
			</div>
			
			<div class="col-sm-3">
			{!! Form::select('county', array(),1, array('class' => 'form-control')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('user/fields.detailed_address'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('address',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group" id="data_3">
			{!! Form::label(trans('user/fields.birthday'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				<div class="input-group date">
	                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                {!! Form::text('birthday',null,['class'=>'form-control']) !!}
	            </div>
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group ">
			{!! Form::label(trans('user/fields.description'),null,['class'=>'col-sm-2 control-label']) !!}
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