
var keycode = 0;

function setGame(){
    setGlobalEvents();
    setControlGames();
    setInterval(intervalLaunch,300);
    load();
}

function setGlobalEvents(){
    $(document).on('touchend touchstart', function(event){
      event.stopPropagation();
      event.preventDefault();
    });
    $(document).on('swipeleft swiperight swipe tap taphold vclick vmouseover vmousemove vmousedown vmouseup vmousecancel', '.selector', function(event) {
      event.stopPropagation();
      event.preventDefault();
    });
    window.addEventListener("resize", function(evt){load();}, false);
    window.addEventListener('orientationchange', function(evt) { load(); }, false);
}

function removeGlobalEvents(){
    $(document).off('touchend touchstart');
    $(document).off('swipeleft swiperight swipe tap taphold vclick vmouseover vmousemove vmousedown vmouseup vmousecancel');
}

function setControlGames(){
    //Para iniciar el juego
    $("#pacman").on('touchend touchstart tap mouseover mousemove', function(event){
        launchKeyDown(78);
        $("#pacman").off('touchend touchstart tap mouseover mousemove');
    });
    //Al tocar las flechas, sustituimos el evento por del teclado correspondiente
    $('#control-up').on('touchend touchstart touchend touchcancel tap mouseover mousemove',function(e){
        addKeyDown(38);
    });
    $('#control-down').on('touchend touchstart touchend touchcancel tap mouseover mousemove',function(e){
        addKeyDown(40);
    });
    $('#control-left').on('touchend touchstart touchend touchcancel tap mouseover mousemove',function(e){
        addKeyDown(37);
    });
    $('#control-right').on('touchend touchstart touchend touchcancel tap mouseover mousemove', function(e){
        addKeyDown(39);
    });
}

function load(){

    var el = document.getElementById("pacman");
    var width = $(window).width();
    var height = $(window).height();

    //Si la tiene inclinada le obligamos a rotar
    if(height<400){
        $("#game-message").css("display","block");
        return;
    }else{
      $("#game-message").css("display","none");
    }

    blockSize = width / 19;
    canvasWidth  = blockSize * 19;
    canvasHeight = blockSize * 22 + 30;
    gameHeight = canvasHeight + 220;

    //Verficamos que se ajuste bien con el ancho sino ponemos el maximo de la altura
    if(gameHeight > height){
        gameWidth = (((height - 240)/22)*19)*0.94;
    }else{
        gameWidth = width*0.95;
    }
    $("#page").css("display","none");
    $("#pacman").css("width",gameWidth+"px");
    $("#game-container").css("display","block");

    if (Modernizr.canvas && Modernizr.localstorage &&
        Modernizr.audio && (Modernizr.audio.ogg || Modernizr.audio.mp3)) {
        if(!PACMAN.isLoaded()){
            window.setTimeout(function () { PACMAN.init(el, "/"); }, 0);
        } else {
            PACMAN.resize(el,"/");
        }
    } else {
        el.innerHTML = "Sorry, needs a decent browser<br /><small>" +
          "(firefox 3.6+, Chrome 4+, Opera 10+ and Safari 4+)</small>";
    }
}

function addKeyDown(newKeycode){
    keycode = newKeycode;
    launchKeyDown(keycode);
}

function intervalLaunch(){
    launchKeyDown(keycode);
}

function launchKeyDown(keycode){
    var oEvent = document.createEvent('KeyboardEvent');
    Object.defineProperty(oEvent, 'keyCode', {
                get : function() {
                    return this.keyCodeVal;
                }
    });
    Object.defineProperty(oEvent, 'which', {
                get : function() {
                    return this.keyCodeVal;
                }
    });
    if (oEvent.initKeyboardEvent) {
        oEvent.initKeyboardEvent("keydown", true, true, document.defaultView, false, false, false, false, keycode, keycode);
    } else {
        oEvent.initKeyEvent("keydown", true, true, document.defaultView, false, false, false, false, keycode, 0);
    }
    oEvent.keyCodeVal = keycode;
    if (oEvent.keyCode !== keycode) {
        alert("keyCode mismatch " + oEvent.keyCode + "(" + oEvent.which + ")");
    }
    document.dispatchEvent(oEvent);
}
