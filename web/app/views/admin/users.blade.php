@extends("admin.index")

@section('header_includes')
	@parent
	{{ HTML::style('css/jquery.dataTables.min.css'); }}
@stop
 
@section('content')

	<div class="row">
		<div class="col-md-12">
			<table id="dataContainer" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th> <!--Expandible row button --> </th>
						<th><!--id (hidden) --></th>
						<th>{{ Lang::get('ui.name'); }}</th>
						<th>{{ Lang::get('ui.isExpert'); }}</th>
						<th>{{ Lang::get('ui.isValidator'); }}</th>
						<th>{{ Lang::get('ui.isAdmin'); }}</th>
						<th>{{ Lang::get('ui.organization'); }}</th>
						<th>{{ Lang::get('ui.created'); }}</th>
						<th> <!--Buttons --> </th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th> <!--Expandible row button --> </th>
						<th><!--id (hidden) --></th>
						<th>{{ Lang::get('ui.name'); }}</th>
						<th>{{ Lang::get('ui.isExpert'); }}</th>
						<th>{{ Lang::get('ui.isValidator'); }}</th>
						<th>{{ Lang::get('ui.isAdmin'); }}</th>
						<th>{{ Lang::get('ui.organization'); }}</th>
						<th>{{ Lang::get('ui.created'); }}</th>
						<th> <!--Buttons --> </th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	
@stop

@section('footer_includes')
	@parent
	{{ HTML::script('js/jquery.dataTables.min.js'); }}
	{{ HTML::script('js/pages/users.js'); }}
@stop