<!DOCTYPE html>
<html>
<head>
	<title>articles</title>
	<meta charset="utf-8">
</head>
<body>
<ul>
	@foreach($articles as $article)
	<li>
		<a href="{{ url('article',$article->id) }}">
			<h2>{{ $article->title }}></h2>
		</a>
	</li>
	@endforeach
</ul>
</body>
</html>