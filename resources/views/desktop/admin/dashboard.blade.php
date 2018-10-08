@extends('admin')
@section('content')
<div class="container-fluid">
	<div class="row">
      <div class="col-lg-12">
          <h2 class="page-header">Dashboard</h2>
			</div>
	</div>
	<div class="row">
			<div class="col-lg-6">
					<div class="panel panel-default">
						<div class="panel-heading">
						    Last Transactions
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
						    <div class="dataTable_wrapper">
						        <table class="table table-striped table-bordered table-hover" id="dataTables">
						            <thead>
						                <tr>
						                    <th>Ip</th>
						                    <th>Amount</th>
						                    <th>Date</th>
						                </tr>
						            </thead>
						        </table>
						    </div>
						</div>
				</div>
		</div>	
		<div class="col-lg-6">
				@include('admin.widgets.stats')
		</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
		$('#dataTables').DataTable({
				paging:   false,
				ordering: false,
				info:     false,
				searching:     false,
				orderFixed: [ 0, 'asc' ],
				processing: true,
				serverSide: true,
				ajax: '/admin/ajax/transactions?orderby=created_at&dir=asc&start=0&length=10&limit=true',
				columns: [
						{data: 'ip', name: 'ip'},
						{data: 'amount', name: 'amount'},
						{data: 'created_at', name: 'created_at'},
				]
		 });
});
</script>
@endsection
