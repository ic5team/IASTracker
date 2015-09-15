<nav class="navbar navbar-default" role="navigation" id="profile-bar">
	<div style="padding: 0;">
		<div class="collapse navbar-collapse" style="padding: 0;">
			<div class="wrapper">
				<div class="left">
					<ul class="nav navbar-nav" id="logo-and-user-bar">
						<li id="navbar-logo">
							<a href="<?php echo Config::get('app.urlPublic')?>">
								{{ HTML::image('img/thumbs/'.$data->logo, $data->logoAlt, array('class' => 'navbar-logo-img', 'id' => 'imgLogoBarra')); }}
							</a>
						</li>
					<?php 
	if(property_exists($data, 'isLogged') && $data->isLogged) 
	{ 
?>
						<li id="navbar-loguejat">
							<a href="<?php echo Config::get('app.urlPublic').'usuaris/'.$data->nickL?>">
								{{ HTML::image('img/thumbs/users/'.$data->fotoUsuariL, $data->nickL, array('class' => 'navbar-user-img', 'pull-left', 'id' => 'imgPerfilBarra')); }}
								{{$data->nickL}}
								<ul class="nav navbar-nav">
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
							<button role="button" class="btn btn-large btn-primary" type="button" data-toggle="modal" onclick="showSignUpModal()">{{Lang::get('ui.signup')}}</button>
							<button role="button" class="btn btn-large btn-success" type="button" data-toggle="modal" onclick="showLogInModal()">{{Lang::get('ui.login')}}</button>
						</li>
<?php 
	} 
?>
					</ul>
				</div>	    
				<div class="right">
					<ul class="nav navbar-nav" id="languages-bar">
						<li id="navbar-languages">
							<div class="form-group pull-right" style="margin: 0; min-width:250px;">
								<ul class="nav navbar-nav">
<?php
	for($i=0; $i<count($data->languages); ++$i)
	{
?>
									<li>
										<a href="?lang={{$data->languages[$i]->locale}}">
											{{ HTML::image('img/thumbs/flags/'.$data->languages[$i]->img, $data->languages[$i]->name, array('class' => 'navbar-logo-img', 'pull-right')); }}
										</a>
									</li>
<?php
	}
?>
								</ul>
							</div>
						</li>
						<li id="navbar-info">
							<ul class="nav navbar-nav">
								<li>
									<a href="#" onclick="showEUInfo()">
										{{ HTML::image('img/thumbs/flags/europeFlag.jpg', Lang::get('ui.euInfo'), array('class' => 'navbar-logo-img', 'pull-right')); }}
									</a>
								</li>
								<li>
									<a href="#" onclick="showIC5Info()">
										{{ HTML::image('img/thumbs/flags/ic5Logo.png', Lang::get('ui.ic5Info'), array('class' => 'navbar-logo-img', 'pull-right')); }}
										{{Lang::get('ui.ic5Info')}}
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div> 
			</div>
		</div>
	</div>
</nav>