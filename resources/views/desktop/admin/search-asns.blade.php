@extends('admin')
@section('content')

<div class="container-fluid">
	<div class="row">
	    <div class="col-lg-12">
	          <h2 class="page-header">Transactions by ASN - IP/Segments <small>(Autonomous System Network)</small></h2>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
				    <div class="dataTable_wrapper">
				        <table class="table table-striped table-bordered table-hover" id="dataTable">
				            <thead>
				                <tr>
				                    <th>Segment A</th>
				                    <th>Segment B</th>
				                    <th>Total transactions</th>
				                    <th style='text-align:center'>Actions</th>
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
				ajax: '/admin/ajax/search-asns',
				columns: [
					{data: 'a', name: 'a'},
					{data: 'b', name: 'b'},
					{data: 'total', name: 'total'},
					{data: 'actions', name: 'actions', orderable: false, searchable: false}
				]
		 });
});
</script>
@endsection
