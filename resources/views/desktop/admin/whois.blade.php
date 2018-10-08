@extends('admin')
@section('content')
<div class="container-fluid">
	<div class="row">
      <div class="col-lg-12">
          <h2 class="page-header">Whois</h2>
			</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="well bs-component">
	  			<form class="form-horizontal" role="form" method="POST" action="">
					<fieldset>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-lg-2 control-label">Host/IP:</label>
							<div class="col-lg-10">
								<input type="host" class="form-control" name="host" value="{{$host}}" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12" style="text-align:right">
								<button type="submit" class="btn btn-primary">Check</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<?php if(!empty($winfo)): ?>
		<div style="float:right;">
			<form action="/admin/block" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="host" value="{{$host}}" />
				<button type="submit" class="btn btn-primary">Block Net</button>
			</form>
		</div>
		<h3>Host info:</h3>
		<?php echo $winfo; ?>
	<?php endif; ?>
	</div>
</div>
@endsection
