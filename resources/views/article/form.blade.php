		{!! Form::label('文章标题') !!}
		{!! Form::text('title',null,['class'=>'form-input', 'data-type'=>0]) !!}

		{!! Form::label('文章内容') !!}
		{!! Form::textarea('content',null,['class'=>'form-input', 'data-type'=>0]) !!}

		{!! Form::label('发布时间') !!}
		{!! Form::input('date','published_at',date('Y-m-d'),['class'=>'form-input', 'data-type'=>0]) !!}
		
		{!! Form::submit('发布',['class'=>'sub']) !!}