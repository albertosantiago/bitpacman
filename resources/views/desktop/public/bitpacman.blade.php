@extends('app')
@section('content')
<script type="text/javascript">
  var SHATOSHIS = true;
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-push-3" style="text-align:center" >
            {!! Ad::getSlot("index.top") !!}
            <div>
                <h1 style="text-align:center;font-size:18px;">{{Lang::get('app.index.title')}}</h1>
            </div>
            @if (Session::has('no-founds'))
                <script type="text/javascript">
                    var SHATOSHIS = false;
                </script>
                <div class="alert alert-dismissible alert-danger">
                  <div class="bs-component">
                      <div class="">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <strong>{{ Session::get('no-founds') }}</strong>
                      </div>
                    </div>
                </div>
             @endif
             @if (Session::has('no-ip'))
                <script type="text/javascript">
                  var SHATOSHIS = false;
                </script>
                <div class="alert alert-dismissible alert-danger">
                  <div class="bs-component">
                      <div class="">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <strong>{{ Session::get('no-ip') }}</strong>
                      </div>
                    </div>
                </div>
             @endif
             @if (Session::has('no-address'))
                <script type="text/javascript">
                  var SHATOSHIS = false;
                </script>
                <div class="alert alert-dismissible alert-danger">
                  <div class="bs-component">
                      <div class="">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <strong>{{ Session::get('no-address') }}</strong>
                      </div>
                    </div>
                </div>
             @endif
             @if (Session::has('banned'))
                 <script type="text/javascript">
                     var SHATOSHIS = false;
                 </script>
                 <div class="alert alert-dismissible alert-danger">
                   <div class="bs-component">
                       <div class="">
                         <button data-dismiss="alert" class="close" type="button">×</button>
                         <strong>{{ Session::get('banned') }}</strong>
                       </div>
                     </div>
                 </div>
              @endif

             <div id="pacman" style="margin:0 auto;width:100%;z-index:1"></div>
             <script src="/js/modernizr-1.5.min.js"></script>

             <?php if(App::environment('local','staging')): ?>
                  <script src="/js/pacman.js"></script>
             <?php else: ?>
                  <script src="/pacman.js"></script>
             <?php endif; ?>


             <script type="text/javascript">
                var el = document.getElementById("pacman");

                var width = $("#pacman").width();
                var height = $(window).height();

                var gameWidth = 0;
                var gameHeight = width * 1.3;

                if(gameHeight > height){
                    gameWidth = height/1.4;
                }else{
                    gameWidth = width*0.90;
                }

                $("#pacman").css("width",gameWidth+"px");

                if (Modernizr.canvas && Modernizr.localstorage &&
                    Modernizr.audio && (Modernizr.audio.ogg || Modernizr.audio.mp3)) {
                    window.setTimeout(function () { PACMAN.init(el, "/"); }, 0);
                } else {
                    el.innerHTML = "Sorry, needs a decent browser<br /><small>" +
                      "(firefox 3.6+, Chrome 4+, Opera 10+ and Safari 4+)</small>";
                }

                function mute(){
                    PACMAN.mute();
                    checkMuteButtons();
                }

                function checkMuteButtons(){
                    var muted = (PACMAN.isMuted()==="true");
                    if(muted===true){
                        $("#pacman-mute-button").css("display","none");
                        $("#pacman-unmute-button").css("display","block");
                    }else{
                        $("#pacman-mute-button").css("display","block");
                        $("#pacman-unmute-button").css("display","none");
                    }
                }

                $(function(){
                    checkMuteButtons();
                });

            </script>
            <button onclick="mute()" id="pacman-mute-button" class='btn btn-default btn-sm pull-right game-button'>
                <span>Silenciar</span>&nbsp;&nbsp;<span class="glyphicon glyphicon-volume-up" ></span>
            </button>
            <button onclick="mute()" id="pacman-unmute-button" style="display:none" class='btn btn-default btn-sm pull-right game-button'>
                <span>Activar Sonido</span>&nbsp;&nbsp;<span class="glyphicon glyphicon-volume-off" ></span>
            </button>
            {!! Ad::getSlot("index.bottom") !!}
        </div>
        <div class="col-xs-6 col-md-3 col-md-pull-6">
            <?php if(!((Session::has('no-founds')) || (Session::has('no-ip')) || (Session::has('banned')) || (Session::has('no-address')))): ?>
            <div class="bs-component" style="text-align:center;">
                <h4>{{trans('app.index.noplay-title')}}</h4>
                <p>{{ trans('app.index.noplay-message', ['amount'=>$directPayment])}}</p>
                <a id="noPlayButton" class="btn btn-default btn-lg" href="">{{Lang::get("app.index.wait")}} 20 {{Lang::get("app.index.seconds")}}</a>
                <br/><br/>
                <p>{{trans('app.index.noplay-whilePhrase')}}</p>
                <script type="text/javascript">
                    var enableCounter = 20;
                    $("#noPlayButton").click(function(e){
                        e.preventDefault();
                    })

                    function enableButton(){
                        enableCounter--;
                        var text = '';

                        if(enableCounter>0){
                            text = '{{Lang::get("app.index.wait")}} '+enableCounter+' {{Lang::get("app.index.seconds")}}'
                            $("#noPlayButton").html(text);
                            window.setTimeout(enableButton,1000);
                        }else{
                            $("#noPlayButton").unbind( "click" );
                            $("#noPlayButton").attr("href", '{{ action('MainController@getReward')}}');
                            $("#noPlayButton").html("{{trans('app.index.noplay-button',['amount'=>$directPayment])}}");
                        }
                    }
                    $(function(){
                        window.setTimeout(enableButton,1000);
                    })
                </script>
            </div>
            <br/>
            <?php endif; ?>
            <div style="text-align:center">
            {!! Ad::getSlot("index.lateral") !!}
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="bs-component" style="text-align:center;">
                <h4>{{Lang::get('app.index.referral_title')}}</h4>
                <p>http://bitpacman.com/?ref={{Lang::get('app.index.referral_your_address')}}</p>
                <div class="bs-component" style="text-align:center;">
                    <h4>{{trans('app.index.todaypayments-title')}}</h4>
                    <p>{{ trans('app.index.todaypayments-message', ['amount'=>$todayPayments])}}</p>
                </div>
            </div>
            <hr/>
            <div class="bs-component" style="text-align:center;">
                <h4 style="font-size:1.5em;padding-bottom:20px;padding-top:10px;">{{Lang::get('app.index.more_from_wetdog')}}</h4>
                <a style="font-family:Roboto, Arial;color:#2690C2;font-weight:bold;font-size:1.3em" href="http://pornlists.net">Pornlists <img src="/img/pornolistas-logo.png" style="width:32px;margin-left:-5px;padding-left:0px;"></a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="getRewardBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal content-->
            <div class="modal-header">
  		        <h4>{{Lang::get('app.index.get_reward_title')}}</h4>
            </div>
            <div class="modal-body">
    	        <p>{!!Lang::get('app.index.get_reward_message')!!}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location='{{ action('MainController@index')}}'">{{Lang::get('app.index.try_again')}}</button>
                &nbsp;&nbsp;{{Lang::get('app.global.or')}}&nbsp;&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal"  onclick="window.location='{{ action('MainController@getReward')}}'">{{Lang::get('app.index.get_reward_button')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="limitReachBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal content-->
            <div class="modal-header">
      		    <h4>{{Lang::get('app.index.limit_reach_title')}}</h4>
            </div>
            <div class="modal-body">
                <p>{!!Lang::get('app.index.limit_reach_message')!!}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="PACMAN.setState(PLAYING)">{{Lang::get('app.index.limit_reach_continue')}}</button>
                &nbsp;&nbsp;{{Lang::get('app.global.or')}}&nbsp;&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal"  onclick="window.location='{{ action('MainController@getReward')}}'">{{Lang::get('app.index.get_reward_button')}}</button>
            </div>
        </div>
    </div>
</div>
<br/><br/>
<br/><br/>
{!! Ad::getDependencies() !!}
@endsection
