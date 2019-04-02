<div id="validationModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id="contentModalContents">
				<div class="row">
					<div class="col-md-12">
						{{Lang::get('ui.addValidationText')}}
					</div>
				</div>
				<div class="row" style="text-align: center;">
					<div class="col-md-12">
						<textarea id="validationText" col="100" row="50" type="text" value="" style="width: 100%; height: 250px;"></textarea>
					</div>
				</div>
				<div id="validationTextError" class="row alert alert-danger" style="display:none;">
					<div class="col-md-12">
						{{Lang::get('ui.validationTextError')}}
					</div>
				</div>
				<div id="serverError" class="row alert alert-danger" style="display:none;">
					<div class="col-md-12" id="serverErrorMessage">
					</div>
				</div>
				<div class="modal-footer">
					<div id="modalButtons">
						<button id="validateButton" type="button" class="btn btn-success">{{Lang::get('ui.validate')}}</button>
						<button id="discardButton" type="button" class="btn btn-success" style="display:none;">{{Lang::get('ui.discard')}}</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">{{Lang::get('ui.dismissAction')}}</button>
					</div>
					<div id="modalLoading" style="display:none;">
						<img src="{{Config::get('app.urlImg')}}/loader.gif" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>