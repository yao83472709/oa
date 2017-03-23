<!DOCTYPE html lang="en">
<html>
<head>
	<meta charset="UTF-8">
	<title>艾邦视觉-需求</title>
</head>
<body>
	<table>
        <thead>
	        <tr>
	            <th>需求</th>
	            <th>价格</th>
	            <th>投标状态</th>
	            <th></th>
	        </tr>
        </thead>
        <tbody>
			@foreach ($newData as $demand)
			<tr>
                <td>{{ $demand['title'] }}</td>
                <td>{{ $demand['price'] }}</td>
                <td>{{ $demand['partake'] }}</td>
                <td><a href="{{ $demand['link'] }}">点击查看详细</a></td>
            </tr>
            @endforeach
        </tbody>
	</table>	
</body>
</html>
