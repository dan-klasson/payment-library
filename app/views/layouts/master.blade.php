<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8"> 
	 <title>@yield('title')</title>
	 <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	 <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-theme.min.css') }}">
	 <script type="text/javascript" src="{{ asset('assets/js/jquery-2.1.3.min.js') }}"></script>
	 <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	 <script type="text/javascript" src="{{ asset('assets/js/jquery.cookie.min.js') }}"></script>
	 @yield('head')
	</head>
	<body>
	@yield('content')
	</body>
</html>

