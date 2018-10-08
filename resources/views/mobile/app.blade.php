<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="{{Lang::get('app.global.meta_description')}}">
	<title>{{Lang::get('app.global.title')}}</title>
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
	<script type="text/javascript">
	    window.cookieconsent_options = {"message":"{{Lang::get('app.global.cookie_acceptance')}}","dismiss":"{{Lang::get('app.global.cookie_acceptance_button')}}","learnMore":"More info","link":null,"theme":"dark-top"};
	</script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>
    <link href="/bower/font-awesome/css/font-awesome.css" rel="stylesheet">
	<script type="text/javascript">
		$(document).bind( "mobileinit", function() {
			$.mobile.ajaxEnabled = false;
			$.mobile.loader.prototype.options.disabled = true;
			$.mobile.ignoreContentEnabled = true;
			$.mobile.pushStateEnabled = false;
		});
	</script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script type="text/javascript">
		$.mobile.loading( "hide" );
		$.mobile.loading().hide();
	</script>
	<!-- End Cookie Consent plugin -->
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!--AntiAdBlock -->
  <script src="/bower/fuck-adblock/fuckadblock.js"></script>
	<script type="text/javascript">
	// Function called if AdBlock is detected
	function adBlockDetected() {
		$("body").html("<br/><br/><br/><br/><h1>Please disable your AdBlock!</h1>");
	}
	$(function(){
		if(typeof fuckAdBlock === 'undefined') {
			adBlockDetected();
		} else {
			fuckAdBlock.onDetected(adBlockDetected);
			// and|or
			fuckAdBlock.on(true, adBlockDetected);
		}

		// Change the options
		fuckAdBlock.setOption('checkOnLoad', false);
		// and|or
		fuckAdBlock.setOption({
			debug: true,
			checkOnLoad: false,
			resetOnEnd: false
		});
	});
	</script>
</head>
<body>
	@yield('out-content')
	<div id="page">
	<nav class="navbar navbar-default ">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ action('MainController@index')}}">Bitpacman</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ action('MainController@about')}}">{{Lang::get('app.global.about')}}</a></li>
					<li><a href="{{ action('ContactController@getContact')}}">{{Lang::get('app.global.contact')}}</a></li>
				</ul>
				@include('widgets.langSelector')
			</div>
		</div>
	</nav>
	@yield('content')
	<footer class="footer">
        <div class="row" style="padding-top:40px;">
			<div class="share42init" style="float:left;margin-left:20px;"></div>
        	<div style="float:right;display:block">
            	<p>A <a href="http://wetdog.co">WetDog Company</a> product.
			</div>
        </div>
	</footer>
	</div>
	<script type="text/javascript" src="/js/google.js"></script>
	<script type="text/javascript" src="/share42/share42.js"></script>
</body>
</html>
