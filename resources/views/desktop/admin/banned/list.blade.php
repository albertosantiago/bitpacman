@extends('admin')
@section('content')
<style type="text/css">
.actionsTd{
	text-align:center;
}
</style>
<div class="container-fluid">
	<div class="row">
      	<div class="col-lg-12">
			<a class="btn btn-primary pull-right" style="margin-top:40px;" href="/admin/bans/new">New Blocked</a>
          	<h2 class="page-header">Banned List</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<!-- /.panel-heading -->
				<div class="panel-body">
				    <div class="dataTable_wrapper">
				        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
				            <thead>
				                <tr>
				                    <th>IP</th>
					                <th>Address</th>
									<th>Reason</th>
				                    <th>Created At</th>
				                    <th>Freedom Date</th>
				                    <th>Actions</th>
				                </tr>
				            </thead>
				        </table>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
	$('#dataTables-example').DataTable({
		processing: true,
		serverSide: true,
		ajax: '/admin/ajax/bans',
		columns: [
			{data: 'ip', name: 'ip'},
			{data: 'address', name: 'address'},
			{data: 'reason', name: 'reason'},
			{data: 'created_at', name: 'created_at'},
			{data: 'freedom_date', name: 'freedom_date'},
			{data: 'actions', className:'actionsTd', name: 'actions', orderable: false, searchable: false}
		]
	 });
});
</script>
@endsection
