@extends('admin')
@section('content')
<div class="container-fluid">
	<div class="row">
      <div class="col-lg-12">
          <h2 class="page-header">Address</h2>
			</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				    Address List
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				    <div class="dataTable_wrapper">
				        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
				            <thead>
				                <tr>
				                    <th>Adress</th>
				                    <th>Total</th>
				                    <th>Max Day</th>
				                    <th>First Entry</th>
				                    <th>Last Entry</th>
				                    <th>Tr</th>
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
		ajax: '/admin/ajax/address',
		columns: [
			{data: 'address', name: 'address'},
			{data: 'total', name: 'total'},
			{data: 'max_day', name: 'max_day'},
			{data: 'first_entry', name: 'first_entry'},
			{data: 'last_entry', name: 'last_entry'},
			{data: 'transfers', name: 'transfers'}
		]
	 });
});
</script>
@endsection
