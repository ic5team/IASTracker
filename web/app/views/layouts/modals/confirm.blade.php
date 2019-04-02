<div id="confirmModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id="contentModalContents">
				<div class="row">
					<div class="col-md-12">
						{{Lang::get('ui.confirmationText')}}
					</div>
				</div>
				<div id="serverDeleteError" class="row alert alert-danger" style="display:none;">
					<div class="col-md-12" id="serverDeleteErrorMessage">
					</div>
				</div>
				<div class="modal-footer">
					<div id="confirmButtons">
						<button id="confirmButton" type="button" class="btn btn-success">{{Lang::get('ui.acceptAction')}}</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">{{Lang::get('ui.dismissAction')}}</button>
					</div>
					<div id="confirmLoading" style="display:none;">
						<img src="{{Config::get('app.urlImg')}}/loader.gif" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>