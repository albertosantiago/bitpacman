@extends('app')
@section('out-content')
<style type="text/css">

i.fa{
    border: 2px solid #fff000;
    border-radius:50%;
    color:#ffff00;
    border-color:#ffff00;
    padding:2%;
    margin:2%;
}

#game-message{
    width:100%;
    height:100%;
    background-color:#000;
    text-align:center;
    margin:0 auto;
    display:none;
    position:absolute;
    top:0px;
    left:0px;
    z-index:1100;
}

#game-container{
    width:100%;
    height:100%;
    background-color:#000;
    text-align:center;
    margin:0 auto;
    display:none;
    position:absolute;
    top:0px;
    left:0px;
    z-index:1000;
}

#pacman{
     margin:0 auto;
}

#control-keys{
    width:95%;
}

.modal-footer .btn{
    font-size:0.9em;
    padding:6px 8px
}

h1{
    text-align:center;
    font-size:18px;
}

.bs-component{
    text-align:center;
}
</style>
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
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location='{{ action('MainController@getReward')}}'">{{Lang::get('app.index.get_reward_button')}}</button>
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
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location='{{ action('MainController@getReward')}}'">{{Lang::get('app.index.get_reward_button')}}</button>
            </div>
        </div>
    </div>
</div>
<div id="game-message">
<h1>{{Lang::get('app.mobile.rotate')}}</h1>
</div>
<div id="game-container">
    <div id="pacman"></div>
    <div id="control-keys">
        <div class="row">
            <i class="fa fa-arrow-up fa-5x fa-lg fa-border" id="control-up"></i>
        </div>
        <div class="row">
            <i class="fa fa-arrow-left fa-5x fa-lg fa-border" id="control-left"></i>
            <i class="fa fa-arrow-down fa-5x fa-lg fa-border" id="control-down"></i>
            <i class="fa fa-arrow-right fa-5x fa-lg fa-border" id="control-right"></i>
        </div>
    </div>
    <div id="mute-toolbar">
        <button id="pacman-cancel-button" class='btn btn-danger btn-sm pull-left'>
            <span>{{Lang::get('app.global.button-cancel')}}</span>&nbsp;&nbsp;<span class="glyphicon glyphicon-remove" ></span>
        </button>
        <button id="pacman-mute-button" class='btn btn-default btn-sm game-button pull-right'>
            <span>{{Lang::get('app.index.button-mute')}}</span>&nbsp;&nbsp;<span class="glyphicon glyphicon-volume-up" ></span>
        </button>
        <button id="pacman-unmute-button" style="display:none" class='btn btn-default btn-sm game-button pull-right'>
            <span>{{Lang::get('app.index.button-unmute')}}</span>&nbsp;&nbsp;<span class="glyphicon glyphicon-volume-off" ></span>
        </button>
    </div>
</div>
@endsection
@section('content')
<script type="text/javascript">
  var SHATOSHIS = true;
</script>
<div class="container-fluid" id="mainContainer">
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-push-3" style="text-align:center;">
            <div>
                <h1>{{Lang::get('app.index.title')}}</h1>
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
             <a id="launchGameButton" class="btn btn-default btn-lg" href="#" onclick="setGame()">Launch Game</a>
             <br/><br/>
            <!-- SCRIPTS PARA INICIAR EL JUEGO -->
             <script src="/js/modernizr-1.5.min.js"></script>
             <?php if(App::environment('testing')): ?>
                  <script src="/js/pacman-mobile.js"></script>
             <?php else: ?>
                  <script src="/pacman.js"></script>
             <?php endif; ?>

             <script src="/js/pacman-mobile-init.js"></script>
             <!-- /FIN SCRIPTS -->
             <?php if(!((Session::has('no-founds')) || (Session::has('banned')) || (Session::has('no-ip')) || (Session::has('no-address')))): ?>
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
                    });

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
                    });

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
                        $("#pacman-mute-button").on('touchstart',function(e){
                            mute();
                        });
                        $("#pacman-unmute-button").on('touchstart',function(e){
                            mute();
                        });
                        $("#pacman-cancel-button").on('touchstart',function(e){
                            window.location.reload();
                        });
                    });

                </script>
            </div>
            <br/>
            <?php endif; ?>
            <div class="bs-component">
                <h4>{{trans('app.index.todaypayments-title')}}</h4>
                <p>{{ trans('app.index.todaypayments-message', ['amount'=>$todayPayments])}}</p>
            </div>
            <div class="bs-component">
                <h4>{{Lang::get('app.index.referral_title')}}</h4>
                <p>http://bitpacman.com/?ref={{Lang::get('app.index.referral_your_address')}}</p>
            </div>
            <div style="text-align:center">
                {!! Ad::getSlot("index.lateral") !!}
            </div>
        </div>
    </div>
</div>
<br/>
{!! Ad::getDependencies() !!}
@endsection
