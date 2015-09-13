									<label for="input-area">{{Lang::get('ui.area')}}</label>
									{{Form::select('area', $areas, null, array('id' => 'input-areas', 'class' => 'form-control'))}}