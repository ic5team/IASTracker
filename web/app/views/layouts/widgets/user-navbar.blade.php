<div class="navbar navbar-default" role="navigation" id="profile-bar">
	<div style="padding: 0;">
		<div class="collapse navbar-collapse" style="padding: 0;">
			<div class="wrapper">
				<div class="left">
					<ul class="nav navbar-nav" id="logo-and-user-bar">
					<?php 
	if(property_exists($data, 'isLogged') && $data->isLogged) 
	{ 
?>
						<li id="navbar-loguejat">
<?php
		if("" != $data->userImage)
		{
?>
							{{ HTML::image('img/thumbs/'.$data->userImage, $data->username, array('class' => 'navbar-user-img', 'pull-left', 'id' => 'imgPerfilBarra', 'style' => 'height: 70px; max-width: 70px;')); }}
<?php
		}
?>
							<div id="userNameDiv" style="margin-top: 5px; font-size: 30px; color:#908787; display: inline-block; max-width: 250px; ">
							{{(strlen($data->username) > 13 ? substr($data->username, 0, 10).'...' : $data->username)}}
							</div>
							<div id="panell-usuari" class="arrow_box menu_box hidden">
								<div style="padding: 10px;">
									<ul class="nav nav-pills nav-stacked">
										<li onclick="updateUserData()"><a href="#">{{ Lang::get('ui.updateData')}}</a></li>
										<li><a href="/password/reset" target="_blank">{{ Lang::get('ui.updatePassword')}}</a></li>
										<li><a href="/admin">{{ Lang::get('ui.administration')}}</a></li>
										<li><a href="/logout">{{ Lang::get('ui.logOut')}}</a></li>
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
						<li id="navbar-languages">
							<div class="form-group pull-right" id="languagesDiv">
								<ul class="nav navbar-nav languageList">
<?php
	for($i=0; $i<count($data->languages); ++$i)
	{
?>
									<li>
										<a href="?lang={{$data->languages[$i]->locale}}" {{$i == count($data->languages)-1 ? 'style="padding-right: 0px;"' : ''}}>
											<div class="flag">
												{{ HTML::image('img/thumbs/flags/'.$data->languages[$i]->img, $data->languages[$i]->name, array('class' => 'navbar-logo-img', 'pull-right', 'style' => 'width: 40px;margin-top:10px;')); }}
												<div class="dotted {{ ($data->languages[$i]->locale == App::getLocale()) ? ' active' : '' }}"></div>
											</div>
										</a>
									</li>
<?php
	}
?>
								</ul>
								<select class="languageSelector">
<?php
	for($i=0; $i<count($data->languages); ++$i)
	{
?>
									<option value="?lang={{$data->languages[$i]->locale}}" {{ ($data->languages[$i]->locale == App::getLocale()) ? ' selected="selected"' : '' }}>
										{{ $data->languages[$i]->name}}
									</option>
<?php
	}
?>
								</select>
							</div>
						</li>
					</ul>
				</div>
				<div class="right">
					<ul class="nav navbar-nav" id="languages-bar">
						<li id="navbar-info">
							<ul class="nav navbar-nav">
								<li>
									<a href="https://www.facebook.com/iastracker" target="_blank" style="padding: 0px;">
										{{ HTML::image('img/thumbs/facebook.png', '', array('class' => 'navbar-logo-img', 'pull-right', 'style' => 'height: 40px; margin-top: 20px;')); }}
									</a>
								</li>
								<li>
									<a href="https://twitter.com/IASTracker_ic5" target="_blank" style="padding: 0px;">
										{{ HTML::image('img/thumbs/twitter.png', '', array('class' => 'navbar-logo-img', 'pull-right', 'style' => 'height: 40px; margin-top: 20px;')); }}
									</a>
								</li>
								<li>
									<a href="https://www.linkedin.com/company/ic5team" target="_blank" style="padding: 0px;">
										{{ HTML::image('img/thumbs/In-2C-75px-TM.png', '', array('class' => 'navbar-logo-img', 'pull-right', 'style' => 'height: 40px; margin-top: 20px;')); }}
									</a>
								</li>
								<li>
									<a href="ic5Info?lang={{App::getLocale()}}" target="_blank" style="padding-top: 0px; padding-bottom: 0px;">
										{{ HTML::image('img/thumbs/flags/ic5Logo.png', '', array('class' => 'navbar-logo-img', 'pull-right', 'style' => 'height: 40px; margin-top: 20px;')); }}
									</a>
								</li>
								<li>
									<a href="iasTrackerInfo?lang={{App::getLocale()}}" target="_blank" style="padding: 0px;">
										{{ HTML::image('img/thumbs/logoIASTracker3.png', '', array('class' => 'navbar-logo-img', 'pull-right', 'style' => 'height: 40px; margin-top: 20px;')); }}
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="center">
					<a href="<?php echo Config::get('app.url')?>" style="padding: 0px;">
						{{ HTML::image('img/thumbs/Home.png', $data->logoAlt, array('class' => 'navbar-logo-img', 'id' => 'imgLogoBarra')); }}
					</a>
				</div>
			</div>
		</div>
	</div>
</div>