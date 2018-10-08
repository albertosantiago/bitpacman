@extends('app')
@section('content')
<div class="container">
    <br/><br/><br/><br/>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-push-3">
            <div class="panel">
                <h1 style="font-size:2em;font-family:Roboto,'Helvetica Neue',Helvetica,Arial,sans-serif;">{{Lang::get('app.success.title')}}</h1>
                <p style="text-align:center">
                    {{Lang::get('app.success.message1')}}{{ Session::get('payment-amount') }}{{Lang::get('app.success.message2')}}<a href=" http://adf.ly/11386787/www.faucetbox.com/en/check/{{ Session::get('address') }}">FaucetBox!</a>
                </p>
                @if(Session::has('extra-award-error'))
                    <div class="alert alert-danger" style="margin:10px;padding:10px;text-align:center;">{{ Session::get('extra-award-error') }}</div>
                @endif
                <h2 style="font-size:2em;text-align:center">{{Lang::get('app.success.promotion_header')}}</h2>
                <p style="text-align:center">{{Lang::get('app.success.promotion_text')}}</p>
                <br/>
                <p style="text-align:center">
                    <?php
                        foreach($promotions as $key => $promotion){
                            if($promotion['enabled']){
                                echo '<a style="margin:0 auto;margin-right:10px;" href="/extra-award?promositeKey='.$key.'" class="btn btn-primary">'.$promotion['public_name'].'</a>';
                            }
                        }
                    ?>
                </p>
                <br/>
            </div>
        </div>
        {!! Ad::getSlot("index.bottom") !!}
    </div>
</div>
<br/><br/>
<br/><br/>
{!! Ad::getDependencies() !!}
@endsection
