@extends('app')
@section('content')
<div class="container-fluid">
    <div class="col-xs-12 col-md-6 col-md-push-3">
      <h1>{{Lang::get('app.about.title')}}</h3>
      <p>{{Lang::get('app.about.p1')}}</p>
      <h2>{{Lang::get('app.about.h2')}}</h2>
      <p>{{Lang::get('app.about.p2')}}</p>
      <p>{{Lang::get('app.about.p3')}}</p>
      <h2>{{Lang::get('app.about.h3')}}</h2>
      <p>{{Lang::get('app.about.p4')}}</p>
      <p>{{Lang::get('app.about.p5')}}</p>
      <h2>{{Lang::get('app.about.h4')}}</h2>
      <p>{{Lang::get('app.about.p6')}}</p>
      <p>{!!Lang::get('app.about.p7')!!}</p>
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
<br/><br/>
<br/><br/>
{!! Ad::getDependencies() !!}
@endsection
