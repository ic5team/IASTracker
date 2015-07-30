@extends("layouts.base")
	
@section('footer_includes')
	@parent
  {{ HTML::script('js/pages/home.js'); }}

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






@section('menu-right')


<?php if(property_exists($data, 'isLogged') && $data->isLogged) 
  { 
?>
          
            
<?php   if($data->nickL != '') 
    { 
?>
              <a href="<?php echo Config::get('app.urlPublic').'usuaris/'.$data->nickL?>">
                  {{ HTML::image('images/fotos/'.$data->fotoUsuariL, $data->nickL, array('class' => 'responsive', 'id' => 'imgPerfilLateral')); }}
                  <h5><?php echo $data->nickL; ?></h5>
              </a>
<?php   } 
    else { 
?>
              <a>
                  {{ HTML::image('images/web/user.png', $data->nickL, array('class' => 'responsive')); }}
                  <h5><?php echo 'Anònim'; ?></h5>
              </a>
            <?php } ?>



            <table id="table-stats" class="table" style="height: 340px; border-radius: 3px;">
            <tr>
              <td colspan="2" style="height: 60px; text-align: left;">

                <table style="width: 100%;">
                  <tr>
                    <td style="width: 30%">

                      <div style="border-radius: 5px; background: rgba(162,200,86,1); text-align: center; padding: 10px 0; color: #FFF;">
                        <span style="font-size: 24px; ">{{ $data->nivellL or '' }}</span>

                      <br />
                      Nivell
                      </div>
                    </td>
                    <td width="70%" style="padding-left: 10px; text-align: left;">

                      <div style="padding-top: 16px; padding-bottom: 6px;">
                                                <div style="color: #aaa">Falten: {{ $data->puntsFaltenL or '' }}<br>Actuals: {{ $data->puntsActualsL or '' }}</div> 
                      </div>

                      <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $data->percentatgeNivellL or '' }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $data->percentatgeNivellL or '0' }}%;">

                        </div>
                      </div>

                    </td>
                  </tr>
                </table>  


              </td>
            </tr>
            <tr>
              <td><div><i class="fa fa-signal" data-toggle="tooltip" data-placement="top" title="Distància acumulada"></i>{{ $data->acumDistL or '' }} Km</div></td>
              <td><div><i class="fa fa-clock-o" data-toggle="tooltip" data-placement="top" title="Temps acumulat"></i>{{ $data->acumTempsL or '' }}</div></td>
            </tr>
            <tr>
              <td><div><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Desnivell positiu acumulat"></i>{{ $data->acumDesPosL or '' }} m</div></td>
              <td><div><i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Desnivell negatiu acumulat"></i>{{ $data->acumDesNegL or '' }} m</div></td>
            </tr>
            <tr>
              <td><div><i class="fa fa-chevron-up" data-toggle="tooltip" data-placement="top" title="Alçada màxima visitada"></i>{{ $data->alcMaxL or '' }} m</div></td>
              <td><div><i class="fa fa-chevron-down" data-toggle="tooltip" data-placement="top" title="Alçada mínima visitada"></i>{{ $data->alcMinL or '' }} m</div></td>
            </tr>

            </table>


      

        <?php } else { ?>
        
        
         
          <a href="#" onclick="showLogin();">
            <img src="<?php echo Config::get('app.urlImg'); ?>thumbs/usuaris/void.png" class="responsive">
          </a>
          <br /><br />

        <?php } ?>


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