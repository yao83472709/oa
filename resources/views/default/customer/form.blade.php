		<div class="form-group name">
			{!! Form::label(trans('customer/fields.company'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('company',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('customer/fields.name'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('name',null,['class'=>'form-control']) !!}
			</div>
		</div>


		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('customer/fields.phone'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('phone',null,['class'=>'form-control']) !!}
			</div>
		</div>		

		<div class="hr-line-dashed"></div>
		<div class="form-group ">
			{!! Form::label(trans('customer/fields.business_type'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::select('type_id', $business_types,null, array('class' => 'form-control')) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group ">
			{!! Form::label(trans('customer/fields.business_origin'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::select('origin_id', $business_orgins,null, array('class' => 'form-control')) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('customer/fields.offer'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('offer',null,['class'=>'form-control']) !!}
			</div>
		</div>
		
		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('customer/fields.email'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('email',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('customer/fields.address'),null,['class'=>'col-sm-2 control-label']) !!}
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
		
		<div class="hr-line-dashed"></div>
		<div class="form-group">
			{!! Form::label(trans('customer/fields.detailed_address'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('address',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group ">
			{!! Form::label(trans('customer/fields.description'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::textarea('description',null,['class'=>'form-control','rows'=>8]) !!}
			</div>
		</div>
		
		{!! Form::hidden('company_id',Auth::user()->company_id,['class'=>'company_id']) !!}

		<div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <button class="btn btn-primary">{{ trans('customer/fields.submit') }}</button>
            </div>
        </div>