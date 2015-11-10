<div class="navbar navbar-default" role="navigation" id="profile-bar">
	<div style="padding: 0;">
		<div class="collapse navbar-collapse" style="padding: 0;">
			<div class="wrapper">
				<div class="left">
					<ul class="nav navbar-nav" id="logo-and-user-bar">
						<li id="navbar-logo">
							<a href="<?php echo Config::get('app.url')?>">
								{{ HTML::image('img/thumbs/'.$data->logo, $data->logoAlt, array('class' => 'navbar-logo-img', 'id' => 'imgLogoBarra')); }}
							</a>
						</li>
					<?php 
	if(property_exists($data, 'isLogged') && $data->isLogged) 
	{ 
?>
						<li id="navbar-loguejat" style="margin-top: 15px;">
<?php
		if("" != $data->userImage)
		{
?>
							{{ HTML::image('img/thumbs/'.$data->userImage, $data->username, array('class' => 'navbar-user-img', 'pull-left', 'id' => 'imgPerfilBarra', 'style' => 'height: 35px; position: absolute;')); }}
<?php
		}
?>
							<div id="userNameDiv" style="margin-left: 55px; margin-top: 5px; font-size: 30px; color:#908787">
							{{$data->username}}
							</div>
							<div id="panell-usuari" class="arrow_box menu_box hidden">
								<div style="padding: 10px;">
									<ul class="nav nav-pills nav-stacked">
										<li onclick="updateUserData()"><a href="#">{{ Lang::get('ui.updateData')}}</a></li>
										<li><a href="password/reset" target="_blank">{{ Lang::get('ui.updatePassword')}}</a></li>
										<li><a href="admin">{{ Lang::get('ui.administration')}}</a></li>
										<li><a href="logout">{{ Lang::get('ui.logOut')}}</a></li>
									</ul>
								</div>
							</div>
						</li>
<?php 
	} 
	else if(!Input::has('token'))
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
											{{ HTML::image('img/thumbs/flags/'.$data->languages[$i]->img, $data->languages[$i]->name, array('class' => 'navbar-logo-img', 'pull-right', 'style' => 'width: 30px;margin-top:10px;')); }}
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
									<a href="ic5Info?lang={{App::getLocale()}}" target="_blank" style="padding-top: 0px; padding-bottom: 0px; margin-top:10px;">
										{{ HTML::image('img/thumbs/flags/ic5Logo.png', '', array('class' => 'navbar-logo-img', 'pull-right')); }}
									</a>
								</li>
								<li>
									<a href="iasTrackerInfo?lang={{App::getLocale()}}" target="_blank">
										{{ HTML::image('img/thumbs/logoIASTracker.png', '', array('class' => 'navbar-logo-img', 'pull-right', 'style' => 'margin-top: 10px;')); }}
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div> 
			</div>
		</div>
	</div>
</div>