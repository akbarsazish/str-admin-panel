<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
</head>

<body>
    <style>
        html {
    overflow: hidden;
    height: 100%;
    background: #191919;
    width: 100%;
}

#canvas {
    background: url('https://marclopezavila.github.io/planet-defense-game/img/space.jpg') no-repeat;
    width: 100%;
    height: 100%;
    background-size: cover;
}

#canvas.playing {
    cursor: url('https://marclopezavila.github.io/planet-defense-game/img/aim_red.png') 17.5 17.5,auto !important;
}
 .goBack{
            text-decoration:none; width:55px;
            padding:10px;
            color:white; background-color:#ef3d52;
            border-radius:8px; z-index:999;
            right:2%; top:5%;
            position:fixed; text-align:center;
            font-weight:bold;
        } 

    </style>
	<a href="{{url('/saveEarth')}}" class="goBack">    بازگشت    </a>
	<audio controls="controls" id="fire" src="{{url('/resources/assets/js/jsGame/fire.mp3')}}" type="audio/mp3" style="display:none;"></audio>
	 <audio controls="controls" id="boomb" src="{{url('/resources/assets/js/jsGame/boomb.mp3')}}" type="audio/mp3" style="display:none;"></audio>
    <canvas id="canvas"></canvas>
    <a href="https://codepen.io/Loopez10/full/dMaVdQ" class="full-screen" target="_blank"></a>
    <script src="{{ url('resources/assets/js/jquery.min.js')}}"></script>
    <script src="{{url('/resources/assets/js/jsGame/planetGame.js')}}"></script>
</body>
	
<script>
	
$(document).ready(function(){
 var keyCodes = [61, 107, 173, 109, 187, 189];

 $(document).keydown(function(event) {   
   if (event.ctrlKey==true && (keyCodes.indexOf(event.which) != -1)) {
  
     event.preventDefault();
    }
 });

 $(window).bind('mousewheel DOMMouseScroll', function (event) {
    if (event.ctrlKey == true) { 
      event.preventDefault();
    }
  });
});

window.addEventListener('wheel', e => {
  if (e.ctrlKey) {
    e.preventDefault();
  }
}, { passive: false });
	
</script>
</html>