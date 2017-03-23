@extends('default.layouts.master')
@section('title', '艾邦视觉_登录')
@section('self_head')
<link href="/css/login.css" rel="stylesheet">
<script>
    if (window.top !== window.self) {
        window.top.location = window.location;
    }
</script>
@endsection

@section('content')
<body class="signin">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-7">
                <div class="signin-info">
                    <div class="logopanel m-b">
                        <h1>[ Abon Vision ]</h1>
                    </div>
                    <div class="m-b"></div>
                    <h4>欢迎使用 <strong>艾邦视觉办公管理系统</strong></h4>
                    <ul class="m-b">
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势一 厉害厉害厉害厉害</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势二 厉害厉害厉害厉害</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势三 厉害厉害厉害厉害</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势四 厉害厉害厉害厉害</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势五 厉害厉害厉害厉害</li>
                    </ul>                  
                </div>
            </div>
            <div class="col-sm-5">
                {!! Form::open(['url'=>'auth/login','class'=>'m-t','role'=>'form']) !!}                
                    <h4 class="no-margins">登录：</h4>
                    <p class="m-t-md">登录到艾邦视觉办公管理系统</p>
                    {!! Form::text('username',null,['class'=>'form-control uname','placeholder'=>'用户名']) !!}
                    <input type="password" class="form-control pword m-b" name="password" placeholder="密码"/>
                    <a href="">忘记密码了？</a>
                    <button class="btn btn-success btn-block">登录 </button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                &copy; 2015 All Rights Reserved. Abon Vision
            </div>
        </div>
    </div>
</body>
@endsection

@section('self_js')
    <script src="/js/plugins/layer/layer.min.js"></script>
    <script type="text/javascript">

      @if ($errors->has('username'))
          layer.msg("{{ $errors->first('username') }}");
      @endif
      @if ($errors->has('password'))
          layer.msg("{{ $errors->first('password') }}");
      @endif

      $('.btn-block').click(function() {
        username = $('input[name=username]').val();
        password = $('input[name=password]').val();
        if(username == '') {
          layer.tips("{{ trans('auth.uname_required') }}", '.uname', {
            tips: [1, '#3595CC'],
            time: 4000
          });
          return false;
        }
        if(password == '') {
          layer.tips('{{ trans('auth.pwd_required') }}', '.pword', {
            tips: [1, '#3595CC'],
            time: 4000
          });
          return false;
        }
      })

  </script>
@endsection