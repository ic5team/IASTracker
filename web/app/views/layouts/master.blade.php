<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
	    {{ HTML::style('css/cookies-eu-banner.default.css'); }}
	    @yield('head')
	</head>
	<body>
		<div id="cookies-eu-banner" style="display: none;">
			{{Lang::get('ui.cookiesWarning')}}
			<a href="cookies" id="cookies-eu-more">{{ Lang::get('ui.readMore') }}</a>
			<button id="cookies-eu-reject">{{ Lang::get('ui.rejectAction') }}</button>
			<button id="cookies-eu-accept">{{ Lang::get('ui.acceptAction') }}</button>
		</div>
		@yield('body')
		@yield('footer_includes')
		{{ HTML::script('js/cookies-eu-banner.js'); }}
		<script>
			new CookiesEuBanner(function(){
			});
		</script>
	</body>
</html>