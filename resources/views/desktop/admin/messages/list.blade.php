@extends('admin')
@section('content')
<div class="container-fluid">
	<div class="row">
      <div class="col-lg-12">
          <h2 class="page-header">Messages</h2>
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
				                    <th>IP</th>
				                    <th>Mail</th>
					                <th>Message</th>
				                    <th>Date</th>
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
		ajax: '/admin/ajax/messages',
		columns: [
			{data: 'ip', name: 'ip'},
			{data: 'email', name: 'email'},
			{data: 'message', name: 'message'},
			{data: 'created_at', name: 'created_at'}
		]
	 });
});
</script>
@endsection
