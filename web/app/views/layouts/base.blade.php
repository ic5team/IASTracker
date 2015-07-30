@extends('layouts.master')

@section('head')
	<title>
		@yield('title') | <?php echo $data->webName; ?>
		
	</title>

	@section('head_includes')

		{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'); }}
		{{ HTML::script('//code.jquery.com/ui/1.10.4/jquery-ui.min.js'); }}
		{{ HTML::script('/js/plugins/bootstrap/js/bootstrap.min.js'); }}

		<link rel="shortcut icon" href="<?php echo Config::get('app.publicURL'); ?>/favicon.ico" type="image/x-icon">

		{{ HTML::style('bootstrap/css/bootstrap.min.css'); }}
		{{ HTML::style('//fonts.googleapis.com/css?family=Raleway:400,600,300'); }}

	@show

	@section('page-metas')
		<!-- Open Graph data -->
		<meta property="og:title" content="<?php echo $data->webName; ?>"></meta>
		<meta property="og:type" content="article"></meta>
		<meta property="og:url" content="<?php echo Config::get('app.url')?>"></meta>
		<meta property="og:image" content=" <?php echo Config::get('app.publicURL').'images/thumbs/'.$data->logo; ?>"></meta>
		<meta property="og:description" content="<?php echo $data->description; ?>"></meta>
		<meta property="og:site_name" content="<?php echo $data->webName; ?>"></meta>
	@show

@stop



@section('body')
	@section('page_header')
		@include('layouts.widgets.user-navbar')

		<!-- PAGE HEADER -->

		<div style="width: 100%" class="header-bg">
		  <div class="container">
		  <div class="row">
		    <div class="col-md-12">


		    	<div class="row" style="margin-top: 85px;">
		    		<div class="col-md-6">
		    			<a href="{{ url('/') }}"><img src="<?php echo Config::get('app.urlImg'); ?>thumbs/<?php echo $data->logoWeb; ?>" style="height: 100px;"></a>
		    		</div>
		    		<div class="col-md-6">
		    			<div class="row">
			    			<div class="col-md-6-offset-6" id="buscador">

				    			<div class="form-group pull-left" style="margin: 0; min-width:250px;">
			          			<div id="barra-buscador">
				          			<input type="text" class="form-control" placeholder="Cercar" id="search">
					          		
				          		</div>

				        		</div>
								<i class="fa fa-search" style="line-height: auto; cursor: pointer;" onclick="buscarTot()"></i>

							</div>
						</div>

						<div id="resultats-cerca" class="hidden arrow_box" style="margin-top: 4px; min-width:250px; float:right; width:450px; background: white; z-index: 1;">
					          			
		          			<div id="loading-cerca" style="padding-top: 30px;">
		          				<img src="<?php echo Config::get('app.urlImg'); ?>loader.gif">
		          			</div>

		          			<div style="padding: 10px; border-radius: 5px;"><div style="border: 0; border-radius: 5px;">
			          			<div id="result-usuaris" class="hidden">
			          				<div id="titol-usuaris">Usuaris</div>
			          				<div id="cos-usuaris"></div>	
			          			</div>
			          		</div></div>
		          			<div id="no-resultats" class="hidden">
		          				<div id="cos-no-resultats" onclick="buscarTot()"><i class="fa fa-search"></i>Tots els resultats</div>	
		          			</div>
		          		</div>


		    		</div>
		    	</div>
		      
		    </div>
		  </div>
		  </div>
		</div>

	@show

	@yield('main_wrapper')

	@include('layouts.modals.error')

	@include('layouts.modals.login')

	@include('layouts.modals.loginUsuari')

	@include('layouts.modals.contacteOk')


	<?php
		if(isset($data->js))
		{
		
			for($i=0; $i<count($data->js); ++$i)
			{
			?>
				{{ HTML::script('js/'.$data->js[$i]); }}
			<?php
			}
			
		}
	?>

	@section('footer_includes')
		{{-- SCRIPTS DEL FOOTER --}}
		<script>
			var idAj = <?php echo $data->idAj; ?>;
			var idUserLogat = <?php echo $data->idUsr; ?>;
			var idUsrSistema = <?php echo $data->idUsrSistema; ?>;
			var dadesCompletades = '{{$data->dadesCompletades or 'false'}}';
			var nomUsuariFb = '{{$data->nomUsuariFb or ''}}';
			var cognomUsuariFb = '{{$data->cognomUsuariFb or ''}}';
			var urlImgUsuari = '{{$data->urlImgUsuari or 'fotos/web/user.png'}}';
			var urlPublic = "<?php echo Config::get('app.urlPublic'); ?>";
			var urlImg = "<?php echo Config::get('app.urlImg'); ?>";
			var nickUsuari = '{{ $data->nickL or ''}}';
			var fotoFonsWeb = '{{ $data->fotoFons or ''}}';
			$('body').css('background-image', 'url('+ urlImg + 'fotos/' +fotoFonsWeb +')');
		</script>
		<script src="//connect.facebook.net/ca_ES/sdk.js#xfbml=1&appId=<?php echo Config::get('facebook.appId'); ?>&version=v2.0" id="facebook-jssdk"></script>
		<script src="//platform.twitter.com/widgets.js" if="twitter-wjs"></script>
		
		

	@show
	
	

@stop

