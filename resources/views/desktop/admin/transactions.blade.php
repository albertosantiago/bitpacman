@extends('admin')
@section('content')

<div class="container-fluid">
	<div class="row">
	    <div class="col-lg-12">
	          <h2 class="page-header">Transactions</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				    Transactions Tables
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
				    <div class="dataTable_wrapper">
				        <table class="table table-striped table-bordered table-hover" id="dataTable">
				            <thead>
				                <tr>
				                    <th>ID</th>
				                    <th>Adress</th>
				                    <th>Ip</th>
				                    <th>Amount</th>
				                    <th>Referral</th>
				                    <th>Date</th>
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
		$('#dataTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: '/admin/ajax/transactions',
				columns: [
						{data: 'id', name: 'id'},
						{data: 'address', name: 'address'},
						{data: 'ip', name: 'ip'},
						{data: 'amount', name: 'amount'},
						{data: 'referral', name: 'referral'},
						{data: 'created_at', name: 'created_at'},
						{data: 'actions', name: 'actions', orderable: false, searchable: false}
				]
		 });
});
</script>
@endsection
