<nav class="navbar navbar-default" role="navigation" id="profile-bar">
	<div class="container" style="padding: 0;">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" style="padding: 0;">
			<ul class="nav navbar-nav">
<?php 
	if(property_exists($data, 'isLogged') && $data->isLogged) 
	{ 
?>
				<li id="navbar-loguejat">
					<a href="<?php echo Config::get('app.urlPublic').'usuaris/'.$data->nickL?>">
	{{ HTML::image('images/thumbs/'.$data->fotoUsuariL, $data->nickL, array('class' => 'navbar-user-img', 'pull-left', 'id' => 'imgPerfilBarra')); }}
	<?php echo $data->nickL; ?><span class="badge pull-right" style="background: rgba(162,200,86,1);">{{ $data->nivellL; }}</span>
	</a>
	<div id="nivell-usuari" class="arrow_box menu_box hidden">

	<div style="padding: 10px;">

	<div style="padding: 10px; border-bottom: 1px solid #EEE; margin-bottom: 10px;">
	<h4>Punts<span class="pull-right">{{ $data->puntsActualsL or '' }}</span></h4>
	<div class="progress">
	<div class="progress-bar" role="progressbar" aria-valuenow="{{ $data->percentatgeNivellL or '' }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $data->percentatgeNivellL or '0' }}%;">
	</div></div>
	</div>
	<div>
	<ul class="nav nav-pills nav-stacked">
	<li><a href="<?php echo Config::get('app.urlPublic').'usuaris/'.$data->nickL.'/configuracio'?>">Configuració</a></li>
	<li><a href="<?php echo Config::get('app.urlPublic').'logout'?>">Tancar sessió</a></li>
	</ul>
	</div>
	</div>
	<?php } else { ?>
	<a>
	{{ HTML::image('images/web/user.png', $data->nickL, array('class' => 'navbar-user-img', 'pull-left')); }}
	<?php echo 'Anònim'; ?>
	</a>
	<?php } ?>

	<?php 
	$gestions = array();
	$ajuntaments = array();
	$clubs = array();
	$empreses = array();
	$gestions[0] = $clubs;
	$gestions[1] = $empreses;
	$gestions[2] = $ajuntaments;
	$links = array(0 =>Config::get('app.urlPublic').'adm/club/', 1 =>Config::get('app.urlPublic').'adm/empresa/', 
	2 =>Config::get('app.urlPublic').'adm/ajuntament/');
	$nomsMenus = array(0 => 'Clubs', 1 => 'Empreses', 2 => 'Ajuntament');
	if(property_exists($data, 'administracions') && count($data->administracions)>0) 
	{

	for($i=0; $i<count($data->administracions); ++$i) {
	$admin = $data->administracions[$i];
	$gestions[$admin->tipus][] = $admin;
	unset($admin);
	} 
	}
	?>
	<?php  if(count($data->administracions) != 0) { ?>
	<li id="navbar-adm">
	<a href="#"><i class="fa fa-lock"></i>Administració</a>
	<div id="dropdown-administracions" class="arrow_box menu_box hidden">
	<div style="padding: 10px;">
	<ul class="nav nav-pills nav-stacked">

	<?php
	if($data->esAdminAS)
	{
	?>
	<li><a href="<?php echo Config::get('app.urlPublic'); ?>adm/as" style="background-color: #EEE;"><i class="map-icon-jewelry-store"></i>Alter Sport</a></li>
	<?php } ?>

	<?php
	for($i=0; $i<count($gestions); ++$i)
	{

	?>

	<?php
	if(count($gestions[$i]) > 0) {
	?>
	<h5>{{$nomsMenus[$i]}}</h5>
	<?php
	}
	for($j=0; $j<count($gestions[$i]); ++$j)
	{

	?>
	<li>
	<a href="<?php echo $links[$i].$gestions[$i][$j]->nomMaquina ?>"><i class="fa fa-lock"></i><?php echo $gestions[$i][$j]->nom ?> </a>
	</li>
	<?php
	}
	}
	?>

	</ul>
	</div>
	</div>
	</li>
	<?php } ?>

	<li id="li-notificacions">
	<a href="<?php echo Config::get('app.urlPublic').'usuaris/'.$data->nickL.'?tab=1'?>" style="padding: 10px;">Notificacions

	<span id="numNotificacions" style="background: rgba(162,200,86,1)" class="badge">
	<?php if(0 != $data->notificacions) { ?>
	{{$data->notificacions;}}
	<?php } ?>
	</span>
	</a>

	<div id="notificacions" class="arrow_box menu_box hidden">
	<?php if(0 != $data->notificacions) { ?>         
	<script>var numNotificacions = {{$data->notificacions;}}</script>

	<?php } else { ?>
	<script>var numNotificacions = 0</script>

	<?php } ?>
	<div id="loading-notificacions-barra">
	<img src="<?php echo Config::get('app.urlImg'); ?>loader.gif">
	</div>

	<div id="container-notificacions-barra" class="hidden" style=" font-size: 90%; padding: 10px; border-radius: 5px;"><div style="border: 1px solid #EEE; border-radius: 5px;">

	</div></div>
	<div>
	<div id="cos-mes-notificacions" onclick="veureNotificacions()">
	<a href="<?php echo Config::get('app.urlPublic').'usuaris/'.$data->nickL.'?tab=1'?>">
	<i class="fa fa-search"></i>
	Totes les notificacions
	</a>
	</div> 
	</div>
	</div>


	</li>

	<li id="user-stats">
	<div class="data" data-toggle="tooltip" data-placement="bottom" title="Distància acumulada"><i class="fa fa-signal"></i>{{ $data->acumDistL or '' }} Km</div>
	<div class="data" data-toggle="tooltip" data-placement="bottom" title="Temps acumulat"><i class="fa fa-clock-o"></i>{{ $data->acumTempsL or '' }}</div>
	<div class="data" data-toggle="tooltip" data-placement="bottom" title="Desnivell positiu acumulat"><i class="fa fa-plus"></i>{{ $data->acumDesPosL or '' }} m</div>
	<div class="data" data-toggle="tooltip" data-placement="bottom" title="Desnivell negatiu acumulat"><i class="fa fa-minus"></i>{{ $data->acumDesNegL or '' }} m</div>
	<div class="data" data-toggle="tooltip" data-placement="bottom" title="Alçada màxima visitada"><i class="fa fa-chevron-up"></i>{{ $data->alcMaxL or '' }} m</div>
	<div class="data" data-toggle="tooltip" data-placement="bottom" title="Alçada mínima visitada"><i class="fa fa-chevron-down"></i>{{ $data->alcMinL or '' }} m</div>
	</li>



	<?php 	
	} 
	else 
	{ 

	if(!Session::has('noLogin') || ('true' !== Session::get('noLogin')))
	{

	?>

	<li id="navbar-no-loguejat">

	<a href="#" data-toggle="modal"  onclick="showLogin();">Entrar</a>

	</li>
	<?php 
	}
	} 
	?>

	<!-- / <li><a href="<?php //echo 'adm/ajuntament/'. $data->nomMaquinaAj ?>"><i class="fa fa-user"></i>Usuari</a></li>
	<li><a href="<?php //echo 'adm/ajuntament/'. $data->nomMaquinaAj . '/as' ?>"><i class="fa fa-user"></i>Club</a></li>
	<li><a href="<?php //echo 'adm/ajuntament/'. $data->nomMaquinaAj . '/as' ?>"><i class="fa fa-user"></i>Empresa</a></li>
	<li>{{ HTML::link('./adm/ajuntament/'. $data->nomMaquinaAj, 'Ajuntament')}}</li>
	<li><a href="<?php //echo './adm/ajuntament/'. $data->nomMaquinaAj . '/as' ?>"><i class="fa fa-user"></i>Alter Sport</a></li>

	<li><a href="{{ url('general/notificationsSmall') }}">Notificacions<span class="badge pull-right">42</span></a></li>-->

	</ul>
	</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->

	<!--<div class="translation-icons">
	<div id='MicrosoftTranslatorWidget' class='Dark' style='color:white;background-color:#555555'></div><script type='text/javascript'>setTimeout(function(){ {var s=document.createElement('script');s.type='text/javascript';s.charset='UTF-8';s.src=((location && location.href && location.href.indexOf('https') == 0)?'https://ssl.microsofttranslator.com':'http://www.microsofttranslator.com')+'/ajax/v3/WidgetV3.ashx?siteData=ueOIGRSKkd965FeEGM5JtQ**&ctf=True&ui=true&settings=Manual&from=ca';var p=document.getElementsByTagName('head')[0]||document.documentElement;p.insertBefore(s,p.firstChild); }},0);</script>
	<!--
	=======
	<!--<div class="translation-icons">
	<div>
	<a href="#" class="ca" data-placement="0"><img class="flag-traduccio" src="<?php echo Config::get('app.urlImg'); ?>web/ca-flag.png"></a>
	<a href="#" class="en" data-placement="1"><img class="flag-traduccio" src="<?php echo Config::get('app.urlImg'); ?>web/en-flag.png"></a>
	<a href="#" class="fr" data-placement="3"><img class="flag-traduccio" src="<?php echo Config::get('app.urlImg'); ?>web/fr-flag.png"></a>
	<a href="#" class="es" data-placement="2"><img class="flag-traduccio" src="<?php echo Config::get('app.urlImg'); ?>web/es-flag.png"></a>
	</div>
	<div style="font-size: 10px;float: right;">
	<p> Google Translator </p>
	</div>

	</div>
	</div>-->

</nav>