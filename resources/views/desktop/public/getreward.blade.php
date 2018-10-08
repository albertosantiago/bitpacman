@extends('app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-push-3">
            <h2 id="getRewardTitle">{{Lang::get('app.getreward.title')}}</h2><br/>
            <div class="well bs-component">
                <form class="form-horizontal" role="form" method="POST" action="{{ action('MainController@sendReward')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <fieldset>
                        <legend>{{Lang::get('app.getreward.fill_form')}}</legend>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                {!!Lang::get('app.getreward.input_problems')!!}<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputEmail">{{Lang::get('app.getreward.prize')}}</label>
                            <div class="col-lg-10">
                                <span style="font-weight:bold;margin-top:10px;display:block;">{{$points}} Shatoshis</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputEmail">{{Lang::get('app.getreward.address')}}</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="{{Lang::get('app.getreward.address')}}" name="address" id="inputAdress" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputPassword">{{Lang::get('app.getreward.captcha')}}</label>
                            <div class="col-lg-10">
                                {!! HiperCaptcha::render() !!}
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <a class="btn btn-default" type="reset" href="{{ action('MainController@index')}}">{{Lang::get('app.global.try_again')}}</a>
                                &nbsp;&nbsp;&nbsp;{{Lang::get('app.global.or')}}&nbsp;&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-primary" type="submit">{{Lang::get('app.getreward.get_shatoshis')}}</button>
                            </div>
                        </div>
                    </fieldset>
                 </form>
                 <div class="btn btn-primary btn-xs" id="source-button" style="display: none;">&lt; &gt;</div>
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
<br/><br/>
<br/><br/>
{!! Ad::getDependencies() !!}
@endsection
