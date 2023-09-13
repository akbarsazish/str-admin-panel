@extends('layout.layout')
@section('content')

<style>
 
.titlegamer{
  background-image: linear-gradient(-225deg,#231557 0%,#44107a 29%,#ff1361 67%, #fff800 100%);
  background-size: auto auto;
  background-clip: border-box;
  background-size: 200% auto;
  color: #fff;
  background-clip: text;
  text-fill-color: transparent;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: textclip 3s linear infinite;
  display: inline-block;
  font-size: 30px;
  text-align:center;
}

@keyframes textclip {
  to {
    background-position: 200% center;
  }
}
 

  
.saveEarthContainer {
    display: grid;
    grid-template-columns: auto auto auto auto auto;
    gap: 3px;
    padding: 15px;
    z-index: 1;
   
}
@media (max-width :768px) {
  .saveEarthContainer {
    display: grid;
    grid-template-columns: auto auto auto;
    gap: 3px;
    padding: 15px;
    text-align:center;
   
  }
}

.playerDiv {
    margin:0 auto;
    padding: 5px 0;
    position: relative;
}

.gameAvatar{
    width:111px;
    height: 111px;
    border-radius:50%;
	box-shadow: -1px 0px 6px 0px rgba(245,15,15,0.75);
	animation: mymove 3s infinite;
}
@keyframes mymove {
  50% {box-shadow: 0px 0px 15px 8px #4fd1c5;}
}	
	
.moreText {
    width:100px;
    height: 100px;
    border-radius:100%;
    background-color:#4fd1c5;
    font-size:22px;
    cursor:pointer;
}


@keyframes spin { 
  100% { 
    transform: rotateZ(360deg);
  }
}
img.firstRecord {
    box-sizing: border-box;
}​



@media (max-width :920px) {
  .gameAvatar{
    width: 66px;
    height:66px;
    border-radius:100%;
}
}

@media (max-width :920px) {
  .firstAvatar, .secondAvator, .thirdAvatar{
    width: 90px !important;
    height:90px !important;
    border-radius:50%;
}
}
@media (min-width :920px) {
    .buttonGame {
        bottom: 2% !important;
  }
}

.gamerName{
  font-size:12px;
  margin-top:10px;
  font-weight:bold;
  text-align:center;
  color:#000000;
}
.gamerRecord {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color:red;
  font-size: 18px;
  font-weight:bold;


}

.moreUser {
  display:none;
}
.wrapGame {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom:20px;
}



.buttonGame {
  min-width: 200px;
  min-height:40px;
  font-size: 20px;
  font-weight: 600;
  color: #313133;
  background: #4FD1C5;
  background: linear-gradient(90deg, rgba(129,230,217,1) 0%, rgba(79,209,197,1) 100%);
  border: none;
  border-radius: 1000px;
  box-shadow: 12px 12px 24px rgba(79,209,197,.64);
  transition: all 0.3s ease-in-out 0s;
  cursor: pointer;
  outline: none;
  position: fixed;
  bottom: 6%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 5px;
  z-index: auto;
}

.buttonGame::before {
content: '';
  border-radius: 1000px;
  min-width: calc(300px + 12px);
  min-height: calc(60px + 12px);
  border: 6px solid #00FFCB;
  box-shadow: 0 0 60px rgba(0,255,203,.64);
  position: absolute;
  top: 70%;
  left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0;
  transition: all .3s ease-in-out 0s;
}

.buttonGame:hover, .buttonGame:focus {
  color: #313133;
}


.buttonGame::after {
  content: '';
  width: 30px; height: 30px;
  border-radius: 100%;
  border: 6px solid #00FFCB;
  position: absolute;
  z-index: -1;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  animation: ring 1.5s infinite;
}

button:hover::after, button:focus::after {
  animation: none;
  display: none;
}

@keyframes ring {
  0% {
    width: 30px;
    height: 30px;
    opacity: 1;
  }
  100% {
    width: 260px;
    height: 260px;
    opacity: 0;
  }
}


.firstRecordBorder {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 122px !important;
  height: 122px !important;
  border-radius:50% !important;
  content: '';
  background: linear-gradient(60deg, yellow, #f7c434, #efb52f, #f3d516, #ce9225, #ffffff);
  animation: animatedgradient 3s ease alternate infinite;
  background-size: 30% 30%; 
  /* at first it was 300% */
  
}

@media (max-width :920px) {
  .firstRecordBorder {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 110px !important;
      height: 110px !important;
      border-radius:50% !important;
      content: '';
      background: linear-gradient(60deg, yellow, #f7c434, #efb52f, #f3d516, #ce9225, #ffffff);
      animation: animatedgradient 3s ease alternate infinite;
      background-size: 30% 30%; 
      /* at first it was 300% */
}
}

@keyframes animatedgradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}

.secondRecordBorder {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 122px !important;
  height: 122px !important;
  border-radius:50% !important;
  content: '';
  background: linear-gradient(60deg, #878787, #aeb1b5, #d1d1d1, #d1d1d1, #717171, #ffffff);
  animation: animatedgradient 3s ease alternate infinite;
  background-size: 30% 30%; 

  /* at first it was 300% */
  
}
@media (max-width :920px) {
  .secondRecordBorder {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 110px !important;
      height: 110px !important;
      border-radius:50% !important;
      content: '';
      background: linear-gradient(60deg, #878787, #aeb1b5, #d1d1d1, #d1d1d1, #717171, #ffffff);
      animation: animatedgradient 3s ease alternate infinite;
      background-size: 30% 30%; 
    }
}

@keyframes animatedgradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}

.thirdRecordBoarder {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 122px !important;
  height: 122px !important;
  border-radius:50% !important;
  content: '';
  background: linear-gradient(60deg, #bb955c, #d5824a, #c28b70, #baa88f,#d2783a);
  animation: animatedgradient 3s ease alternate infinite;
  background-size: 30% 30%; 

  /* at first it was 300% */
  
}

@media (max-width :920px) {
  .thirdRecordBoarder {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 110px !important;
    height: 110px !important;
    border-radius:50% !important;
    content: '';
    background: linear-gradient(60deg, #bb955c, #d5824a, #c28b70, #baa88f,#d2783a);
    animation: animatedgradient 3s ease alternate infinite;
    background-size: 30% 30%; 
}
}

@keyframes animatedgradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}

@keyframes award {
  50% {box-shadow: -1px 0px 10px 10px gold;}
}	 

.awardWinner {
    position: relative;
    margin: 0 auto 5px;
    padding: 2px 2px;
    text-align: center;
    color:#000;
	  font-size:13px;
	  border-radius:8px;
    z-index: 5;
	
}

.afterBefor1 {
     background-color: #fce37e !important;
}
	
.afterBefor2 {
     background-color: #d3d4d4 !important;
}
	
.afterBefor3 {
     background-color: #ec7147 !important;
}	
	
@keyframes award1 {
  50% {box-shadow: -1px 0px 6px 6px #f7e474;}
}	 

.afterBefor2 {
  animation: award2 3s infinite !important;
}
	
@keyframes award2 {
  50% {box-shadow: -1px 0px 6px 6px #d2d2d2;}
}
	
.afterBefor3 {
  animation: award3 3s infinite !important;
}
	
@keyframes award3 {
  50% {box-shadow: -1px 0px 6px 6px #d2783a;}
}	 

/* ribon for mobile devices  */
@media (max-width: 920px) {
  .awardWinner { 
      position: relative;
      margin: 0 auto 3px;
      padding: 2px 3px;
      text-align: center;
      color:#000;
      animation: award 3s infinite;
      font-size:10px;
      text-align: center !important;
	  border-radius:8px;
   }
}


</style>
<div class="container my-4">
@if($remainDays[0]->dayRemain <= 30)
    <div class="row">
        <h5 class="titlegamer"> بازیکنان برتر تا این لحظه  </h5>
        
		<span id="demo" style="color:black; font-size:16px; text-align:center; margin-bottom:20px;"></span>
    </div>
    <div class="row">
        <div class="saveEarthContainer">
              @foreach($players as $player)
                <div @if($loop->iteration>9) class="playerDiv  moreUser"  @else class="playerDiv" @endif>
                  <span @if($loop->iteration==1) class="awardWinner afterBefor1" @endif
                        @if($loop->iteration==2) class="awardWinner afterBefor2" @endif
                        @if($loop->iteration==3) class="awardWinner afterBefor3" @endif>

                        @if($loop->iteration==1) نفر اول   {{number_format($prizes->firstPrize)}} تومان@endif
                        @if($loop->iteration==2) نفر دوم   {{number_format($prizes->secondPrize)}} تومان@endif
                        @if($loop->iteration==3) نفر سوم   {{number_format($prizes->thirdPrize)}} تومان @endif
                  </span>
                  <span @if( $loop->iteration==1) class="firstRecordBorder" @endif
                    @if($loop->iteration==2) class="secondRecordBorder" @endif
                    @if($loop->iteration==3) class="thirdRecordBoarder" @endif>  
                    <img  @if( $loop->iteration==1) class="gameAvatar firstAvatar" @endif
                          @if($loop->iteration==2) class="gameAvatar secondAvatar" @endif
                          @if($loop->iteration==3) class="gameAvatar thirdAvatar" @endif
                          @if($loop->iteration!=3 and $loop->iteration!=2 and $loop->iteration!=1) class="gameAvatar" @endif
                        src="{{ url('/resources/assets/images/userAvatar.png') }}" alt=""> 
                  </span>
                    <p class="gamerName">{{$player->Name}}</p>
                    <p class="gamerRecord"> {{$player->score}} </p>
                </div>
                @if($loop->iteration==10)
                <div class="playerDiv item10" id="forMoreUser">
                    <span class="moreText p-4" id="moreText" style="display:flex; margin: 0 auto;">
                          بیشتر ... 
                    </span>
                </div>
                @endif
              @endforeach
       </div>
    </div>
    @if($gameId==0)
      <div class="row" style="margin:50px auto; ">
          <div class="wrapGame">
            <a  href="{{url('/planetSave')}}"> <button  class="buttonGame"> ورود به بازی <i class="fas fa-angle-left"></i> </button>  </a>
          </div>
      </div>
    @elseif($gameId==1)
      <div class="row" style="margin:50px auto; ">
        <div class="wrapGame">
          <a  href="{{url('/hextrisGame')}}"> <button  class="buttonGame"> ورود به بازی  <i class="fas fa-angle-left"></i> </button>  </a>
        </div>
      </div>
    @elseif($gameId==2)
    <div class="row" style="margin:50px auto; ">
      <div class="wrapGame">
        <a href="{{url('/resources/assets/tower/index.html')}}"> 
          <button id="playButton" class="buttonGame">  ورود به بازی  <i class="fas fa-angle-left"></i> </button> 
        </a>
      </div>
    </div>
  @endif
  @else

    <div class="row">
      <h5 class="titlegamer"> بازیکنان برتر ماه قبل </h5>
    <div class="row">
        <div class="saveEarthContainer">
          
          @foreach($played as $player)
              @if($loop->iteration<=3)
                <div @if($loop->iteration>9) class="playerDiv  moreUser"  @else class="playerDiv" @endif>
                <span @if($loop->iteration==1) class="awardWinner afterBefor1" @endif
                      @if($loop->iteration==2) class="awardWinner afterBefor2" @endif
                      @if($loop->iteration==3) class="awardWinner afterBefor3" @endif>

                      @if($loop->iteration==1) نفر اول   {{number_format($prizes->firstPrize)}} تومان@endif
                      @if($loop->iteration==2) نفر دوم   {{number_format($prizes->secondPrize)}} تومان@endif
                      @if($loop->iteration==3) نفر سوم   {{number_format($prizes->thirdPrize)}} تومان @endif

                </span>
                  <span @if( $loop->iteration==1) class="firstRecordBorder" @endif
                  @if($loop->iteration==2) class="secondRecordBorder" @endif
                  @if($loop->iteration==3) class="thirdRecordBoarder" @endif>  
                  <img  @if( $loop->iteration==1) class="gameAvatar firstAvatar" @endif
                        @if($loop->iteration==2) class="gameAvatar secondAvatar" @endif
                        @if($loop->iteration==3) class="gameAvatar thirdAvatar" @endif
                        @if($loop->iteration!=3 and $loop->iteration!=2 and $loop->iteration!=1) class="gameAvatar" @endif
                        src="{{ url('/resources/assets/images/userAvatar.png') }}" alt=""> </span>
                  <p class="gamerName">{{$player->Name}}</p>
                </div>
              @endif
            @endforeach
       </div>
    </div>
    @endif
</div>



<script>

 $("#forMoreUser").on("click", () => {
      if($('.moreUser').is(":visible")){
        $('.moreUser').css('display', 'none');
        $('#forMoreUser').css('display', 'none');
        $("#moreText").text("بیشتر ... ");
      } 
    else {
      $('.moreUser').css('display', 'block');
      $("#moreText").text("کمتر ...");
      $('#forMoreUser').css('display', 'none');
    }

  });
// Set the date we're counting down to
var countDownDate = new Date("{{$endOfOpportunity}}").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "روز " + hours + "ساعت "
  + minutes + "دقیقه " + seconds + "ثانیه ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "زمان بازی به اتمام رسید";
  }
}, 1000);
	
	


</script>
@endsection
