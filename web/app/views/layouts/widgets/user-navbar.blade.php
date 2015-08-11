<nav class="navbar navbar-default" role="navigation" id="profile-bar">
	<div class="container" style="padding: 0;">
		<div class="collapse navbar-collapse" style="padding: 0;">
			<ul class="nav navbar-nav">
				<li id="logo">
					<a href="<?php echo Config::get('app.urlPublic')?>">
						{{ HTML::image('images/thumbs/'.$data->logo, $data->logoAlt, array('class' => 'navbar-logo-img', 'pull-left', 'id' => 'imgLogoBarra')); }}
					</a>
				</li>
<?php 
	if(property_exists($data, 'isLogged') && $data->isLogged) 
	{ 
?>
				<li id="navbar-loguejat">
					<a href="<?php echo Config::get('app.urlPublic').'usuaris/'.$data->nickL?>">
						{{ HTML::image('images/thumbs/'.$data->fotoUsuariL, $data->nickL, array('class' => 'navbar-user-img', 'pull-left', 'id' => 'imgPerfilBarra')); }}
						{{$data->nickL}}
						<ul>
							<li id="user-stats">
								<div class="data" data-toggle="tooltip" data-placement="bottom" title="{{$data->numObs}}"><i class="fa fa-signal"></i>{{ $data->numObs or '0' }} {{Lang::get('ui.obs')}}</div>
								<div class="data" data-toggle="tooltip" data-placement="bottom" title="{{$data->pcObs}}"><i class="fa fa-clock-o"></i>{{ $data->pcObs or '' }}</div>
							</li>
						</ul>
					</a>
					<div id="panell-usuari" class="arrow_box menu_box hidden">
						<div style="padding: 10px;">
							<ul class="nav nav-pills nav-stacked">
								<li><a href="<?php echo Config::get('app.urlPublic').'adm'?>">{{ Lang::get('ui.admin')}}</a></li>
								<li><a href="<?php echo Config::get('app.urlPublic').'logout'?>">{{ Lang::get('ui.tancarSessio')}}</a></li>
							</ul>
						</div>
					</div>
				</li>
<?php 
	} 
	else 
	{ 
?>
				<li id="navbar-no-loguejat">
					<a href="#" data-toggle="modal"  onclick="showLogin();">{{Lang::get('ui.login')}}</a>
				</li>
<?php 
	} 
?>
				<li id="navbar-search">
					<div class="form-group pull-right" style="margin: 0; min-width:250px;">
						<div id="barra-buscador">
							<input type="text" class="form-control" placeholder="{{Lang::get('ui.search')}}" id="search">	
						</div>
					</div>
				</li>
				<div id="search-results" class="hidden arrow_box" style="margin-top: 4px; min-width:250px; float:right; width:450px; background: white; z-index: 1;">
					<div id="search-loading" style="padding-top: 30px;">
						<img src="<?php echo Config::get('app.urlImg'); ?>loader.gif">
					</div>
					<div style="padding: 10px; border-radius: 5px;">
						<div style="border: 0; border-radius: 5px;">
							<div id="result">
							</div>
						</div>
					</div>
					<div id="no-resultats" class="hidden">
						{{Lang::get('ui.noSearchResults')}}
					</div>
				</div>
				<li id="navbar-languages">
					<div class="form-group pull-right" style="margin: 0; min-width:250px;">
						<ul>
<?php
		for($i=0; $i<count($data->languages); ++$i)
		{
?>
							<li>
								<a href="#" onclick="setLang({{$data->languages[$i]->locale}})">
									{{ HTML::image('images/thumbs/'.$data->languages[$i]->img, $data->languages[$i]->name, array('class' => 'navbar-logo-img', 'pull-right')); }}
								</a>
							</li>
<?php
		}
?>
						</ul>
					</div>
				</li>
				<li id="navbar-info">
					<ul>
						<li>
							<a href="#" onclick="showEUInfo()">
								{{ HTML::image('images/thumbs/euImg.png', Lang::get('ui.euInfo'), array('class' => 'navbar-logo-img', 'pull-right')); }}
							</a>
						</li>
						<li>
							<a href="#" onclick="showIC5Info()">
								{{ HTML::image('images/thumbs/ic5.png', Lang::get('ui.ic5Info'), array('class' => 'navbar-logo-img', 'pull-right')); }}
								{{Lang::get('ui.ic5Info')}}
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>