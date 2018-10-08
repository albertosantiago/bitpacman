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
			<a href="/admin/banned-ranges/export" target="_blank" class="btn btn-default pull-right" style="margin-top:20px">Export</a>
          	<h2 class="page-header">ASN Banned List</h2>
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
									<th>ASN ID</th>
									<th>ASN Name</th>
									<th>CIDR</th>
					                <th>Start</th>
				                    <th>End</th>
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
		ajax: '/admin/ajax/banned-ranges',
		columns: [
			{data: 'asn_id', name: 'asn_id'},
			{data: 'asn_name', name: 'asn_name'},
			{data: 'cidr', name: 'cidr'},
			{data: 'start', name: 'start'},
			{data: 'end', name: 'end'},
			{data: 'created_at', name: 'created_at'},
			{data: 'freedom_date', name: 'freedom_date'},
			{data: 'actions', className:'actionsTd', name: 'actions', orderable: false, searchable: false}
		]
	 });
});
</script>
@endsection
