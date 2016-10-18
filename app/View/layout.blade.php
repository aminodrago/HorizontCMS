<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }} - {{ Config::get('app.name') }}</title>

	@foreach ($css as $each_css)
    	<link rel="stylesheet" type="text/css" href="{{url($each_css)}}">
	@endforeach

	@foreach ($js as $each_js)
    		<script type="text/javascript" src="{{url($each_js)}}"></script>
	@endforeach

</head>
<body @if(Auth::user()) style='padding-top: 55px' @endif>

  @if (!Auth::guest())
	@include('navbar')
  @endif

	@yield('content')


<div id='whatsup' class='panel panel-primary' ></div>


<?php //include(VIEW_DIR."default/scripts.php") ?>

<footer id='footer' style='bottom:0;position:relative;'>
        <div class='container main-container'>
            <p class='text-muted credit' >
	HorizontCMS &copy 2015 - <?= date('Y'); ?> <a href='http://www.twitter.com/timottarjani'>Timot Tarjani</a>
			</p>
		</div>	
</footer>

</body>
</html>