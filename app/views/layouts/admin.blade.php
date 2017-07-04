<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	@section('header')
		@include('admin.common.header')
	@show
</head>
<body>
<div class="container">
	@section('navigation')
		@include('admin.common.navigation')
	@show

	{{ Notification::showAll() }}
	@include('notifications')
	 
	@if ($errors->any())
		{{ Alert::error(implode('<br>', $errors->all())) }}
	@endif

	@section('content')
		{{ $content }}
	@show	
</div>

<footer class="bs-docs-footer" role="contentinfo">
@section('footer')
	@include('admin.common.footer')
@show	
</footer>
</body>
</html>