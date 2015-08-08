@extends("layouts.base")
	
@section('footer_includes')
	@parent
@stop
 
@section("title")
	Inici
@stop

@section('section-title')
	Inici
@stop

@section('content')

	<div class="ta-container">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<?php for($i=0; $i<count($data->dadesSeccions); ++$i) { ?>
				<?php if($i == 0) { ?>
				<li data-target="#carousel-example-generic" data-slide-to="<?php echo $i ?>" class="active"></li>
				<?php } else{ ?>
				<li data-target="#carousel-example-generic" data-slide-to="<?php echo $i ?>"></li>
				<?php } ?>
				<?php } ?>
			</ol>
	
			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<?php for($i=0; $i<count($data->dadesSeccions); ++$i) { ?>
				<?php if($i == 0) { ?>
				<div class="item active">
					<a href="{{ $data->dadesSeccions[$i]->link or '' }}"><img src="<?php echo Config::get('app.urlImg')?>/fotos/{{ $data->dadesSeccions[$i]->imatge or '' }}" alt="..."></a>
					<div class="carousel-caption">
						{{ $data->dadesSeccions[$i]->titol or '' }}
					</div>
				</div>
				<?php } else{ ?>
				<div class="item">
					<a href="{{ $data->dadesSeccions[$i]->link or '' }}"><img src="<?php echo Config::get('app.urlImg')?>/fotos/{{ $data->dadesSeccions[$i]->imatge or '' }}" alt="..."></a>
					<div class="carousel-caption">
						{{ $data->dadesSeccions[$i]->titol or '' }}
					</div>
				</div>
				<?php } ?>
				<?php } ?>
			</div>
			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	</div>


	<div class="ta-container" id="indretsE-wrapper">
		<div style="overflow: hidden;">
			<h2 class="pull-left">Indrets emblemàtics</h2>
			<div id="botons-desplaca-index" class="pull-right" style="margin-top: 30px;">
				<div class="btn-group btn-group-sm">
					<div class="btn btn-default" onclick="previousIndrets();"><i class="fa fa-caret-left"></i></div>
					<div class="btn btn-default" onclick="nextIndrets();"><i class="fa fa-caret-right"></i></div>
				</div>
			</div>
		</div>
		<div id="ie-container"></div>
	</div>

	<div class="ta-container">
		<h2>Rutes per tipus</h2>
		<div id="rutes-container"></div>
	</div>

	<div class="ta-container">
		<h2>Indrets de pràctica esportiva</h2>
		<div id="indretsPE-container"></div>
	</div>

@stop

@section('main_wrapper')
  <div class="container ta-main-wrapper">
    <div class="row">
      <div class="col-md-9">
        <div class="ta-home-container">
          @yield('content')
        </div>
      </div>
      <div class="col-md-3">

      <?php
        if(!Session::has('noLogin') || ('true' !== Session::get('noLogin')))
        {
      ?>
        <div class="ta-menu-container">
          <h3 class="header">ESPAI PERSONAL</h3>
          @section('menu-right')
            {{-- RIGHT MENU --}}
          @show
        </div>
      <?php
        }
      ?>

        <a href="<?php echo Config::get('app.urlPublic'); ?>app">
        <div class="ta-menu-container">
          <div class="row">
            <div class="col-md-12">
              <h4 class="header">APLICACIÓ MÒBIL</h4>
            </div>
          </div>
          <hr style="margin-top: 0;">
          <div class="row">
            <div class="col-md-4" style="text-align: center;">
              <i class="fa fa-mobile-phone" style="font-size: 36px; background-color: #666; color: #FFF; line-height: 50px; width: 50px; height: 50px; border-radius: 25px;"></i>
            </div>
            <div class="col-md-8">
              <p>Descarrega't la nostra aplicació!</p>
            </div>
          </div>

        </div>
        </a>

        <div class="ta-menu-container">

          <h4 class="header">Activitat recent</h4>
          <div id="loading-mur2" class="hidden">
                <div style="width: 100%; height: 60px; text-align: center; padding-top: 16px"><img src="<?php echo Config::get('app.urlImg'); ?>loader.gif"></div>
              </div>
          <div id="mur-ajuntament"></div>

              <div id="loading-mur">
                <div style="width: 100%; height: 60px; text-align: center; padding-top: 16px"><img src="<?php echo Config::get('app.urlImg'); ?>loader.gif"></div>
              </div>
        </div>

      </div>
    </div>
  </div>
@stop