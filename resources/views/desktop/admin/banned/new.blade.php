@extends('admin')
@section('content')
<div class="container-fluid">
	<div class="row">
      	<div class="col-lg-12">
			<h2 class="page-header">Ban IPs</h2>
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
								<input type="host" class="form-control" placeholder="192.168.2.*" name="host" value="" required>
							</div>
						</div>
                        <p style="padding:10px;">Use regular expressions like 192.168.* to block groups of IPS or simply 192.168.1.1</p>
						<div class="form-group">
							<div class="col-lg-12" style="text-align:right">
								<button type="submit" class="btn btn-primary">Block</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
