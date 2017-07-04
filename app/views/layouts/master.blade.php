<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	@section('header')
		@include('common.header')
	@show
</head>
<body role="document">
<div class="container">
@section('navigation')
	@include('common.navigation')
@show

{{ Notification::showAll() }}
 
@if ($errors->any())

                {{ Alert::error(implode('<br>', $errors->all())) }}

@endif

@section('content')
	{{ $content }}
@show	
</div>

<footer class="bs-docs-footer" role="contentinfo">
@section('footer')
	@include('common.footer')
@show	
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
 <!-- Latest compiled and minified JavaScript -->
 <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
 <script src="{{ URL::to('js/jquery-1.8.0.min.js') }}"></script>
 <script src="{{ URL::to('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
 <script src="{{ URL::to('js/scripts.js') }}"></script>
</body>
</html>