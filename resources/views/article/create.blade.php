<!DOCTYPE html>
<html>
<head>
	<title>添加文章</title>
	<meta charset="utf-8">
</head>
<body>
	{!! Form::open(['url'=>'/article/store']) !!}

	@include('article.form')

	{!! Form::close() !!}

	@include('errors.list')
<script src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">

	onLoginClick();
  function onLoginClick() {
    var username = '';
    var password = '';
    var validate_code = '';

    $.ajax({
      type: "POST",
      url: '/article/store',
      dataType: 'json',
      cache: false,
      data: { title:'aaa',content:'哈哈',_token: "{{csrf_token()}}"},
      success: function(xhr,data) {
      	//alert(xhr.status)
        if(data == null) {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('服务端错误');
          setTimeout(function() {$('.bk_toptips').hide();}, 2000);
          return;
        }
        if(data.status != 0) {
          $('.bk_toptips').show();
          $('.bk_toptips span').html(data.message);
          setTimeout(function() {$('.bk_toptips').hide();}, 2000);
          return;
        }

        $('.bk_toptips').show();
        $('.bk_toptips span').html('登录成功');
        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
        location.href = "/";
      },
      error: function(xhr, status, error) {
      	//alert(xhr.status)
        console.log(xhr);
        console.log(status);
        console.log(error);
      }
    });
  }

</script>
</body>
</html>