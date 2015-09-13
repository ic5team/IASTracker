								<label for="input-regions">{{Lang::get('ui.region')}}</label>
								{{Form::select('regions', $regions, null, array('id' => 'input-regions', 'class' => 'form-control'))}}
								<div id="areaSelect">
									<label for="input-area">{{Lang::get('ui.area')}}</label>
									{{Form::select('area', $areas, null, array('id' => 'input-areas', 'class' => 'form-control'))}}
								</div>