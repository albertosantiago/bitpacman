@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-md-6 col-md-push-3">
			<h2 style="font-family: BDCartoonShoutRegular;text-align:center">{{Lang::get('app.contact.title')}}</h2><br/>
			<div class="well bs-component">
	  			<form class="form-horizontal" role="form" method="POST" action="{{ action('ContactController@postContact')}}">
					<fieldset>
						<legend>{{Lang::get('app.contact.fill_form')}}</legend>
						@if (count($errors) > 0)
							<div class="alert alert-danger">
								{!! Lang::get('app.contact.input_problems') !!}<br><br>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						@if(Session::has('flash_message'))
						    <div class="alert alert-success">
						        {{ Session::get('flash_message') }}
						    </div>
						@endif
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-lg-2 control-label">{{Lang::get('app.contact.email')}}</label>
							<div class="col-lg-10">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">{{Lang::get('app.contact.message')}}</label>
							<div class="col-lg-10">
								<textarea id="textArea" rows="5" class="form-control" name="message" required></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">{{Lang::get('app.contact.captcha')}}</label>
							<div class="col-lg-10">
								{!! HiperCaptcha::render() !!}
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12" style="text-align:right">
								<button type="submit" class="btn btn-primary">{{Lang::get('app.contact.submit')}}</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="col-xs-6 col-md-3 col-md-pull-6">
	      <div style="text-align:center">
	          {!! Ad::getSlot("index.lateral") !!}
	      </div>
	    </div>
	    <div class="col-xs-6 col-md-3">
	        <div style="text-align:center">
	            {!! Ad::getSlot("about.lateral2") !!}
	        </div>
	     </div>
	</div>
</div>
{!! Ad::getDependencies() !!}
@endsection
