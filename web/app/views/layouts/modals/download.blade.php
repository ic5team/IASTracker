<div id="downloadTypeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<b>{{Lang::get('ui.selectFileTypeText')}}</b>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<select id="cbFileFormat">
							<option value="csv">CSV</option>
							<option value="kml">KML</option>
						</select>
					</div>
				</div>
				<br />
				<div class="modal-footer">
					<div id="confirmButtons">
						<button id="confirmButton" type="button" class="btn btn-success" data-dismiss="modal" onclick="downloadObs()">{{Lang::get('ui.acceptAction')}}</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">{{Lang::get('ui.dismissAction')}}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>