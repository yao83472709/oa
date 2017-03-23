		<div class="form-group">
			{!! Form::label(trans('project/member/fields.replace'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				@if($member->bereplace_id)
				<a title="{{ $member->bereplace->name }}" class="edit_member">
                    <img src="{{ $member->bereplace->head_portrait }}" class="img-circle head" alt="{{ $member->bereplace->name }}">
                </a>
				@else
				<button class="btn btn-primary replace" type="button" data-toggle="modal" data-target="#replaceModel">点击替换</button>
				@endif
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('project/member/fields.is_bonus'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				<div class="radio radio-inline">
					{!! Form::radio('is_bonus', 0, true, array('id' => 'inlineRadioa')) !!}
	                <label for="inlineRadioa">{{ trans('project/member/fields.is_bonus_val.0') }}</label>
	            </div>
				<div class="radio radio-info radio-inline">
	                {!! Form::radio('is_bonus', 1, null, array('id' => 'inlineRadiob')) !!}
	                <label for="inlineRadiob"> {{ trans('project/member/fields.is_bonus_val.1') }} </label>
	            </div>
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('project/member/fields.bonus'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::text('bonus',null,['class'=>'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label(trans('project/member/fields.mark'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			@foreach($marks as $key => $val)
				<div class="radio radio-info radio-inline">
					{!! Form::radio('mark', $key, null, array('id' => 'inlineRadio'.$key)) !!}
					<label for="inlineRadio{{ $key }}">{{ $val }}</label>
	            </div>
			@endforeach
			</div>
		</div>

		<div class="hr-line-dashed"></div>
		<div class="form-group description">
			{!! Form::label(trans('project/member/fields.description'),null,['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
			{!! Form::textarea('description',null,['class'=>'form-control','rows'=>3]) !!}
			</div>
		</div>
		
		<div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <button class="btn btn-primary" id="member_submist">{{ trans('customer/status/save.submit') }}</button>
            </div>
        </div>