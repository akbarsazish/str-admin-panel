<!DOCTYPE html>
<html  dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>استارفود</title>
    <meta name="viewport" content="width =device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/png" href="{{ url('/resources/assets/images/part.png')}}"/>
    <script src="{{ url('resources/assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{ url('/resources/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ url('/resources/assets/css/bootstrap.min.css')}}" rel="stylesheet">
   
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>
<style>
* {
  box-sizing: border-box;
}
.row {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}
.column {
  flex: 25%;
  max-width: 25%;
  padding: 0 2px;
  text-align:center;
}
.column img {
  vertical-align: middle;
  height:auto;
}
.caption{
    font-size:18px;
    font-weight:bold;
    margin-bottom:30px;
}

@media (max-width: 920px) {
  .column {
    flex: 50% !important;
    max-width: 50% !important;
  }
}

@media (max-width: 480px) {
  .column {
    flex: 100% !important;
    max-width: 100% !important;
  }
}
.image-open {
    width:100%;
    height:100%;
    cursor: pointer;
}
</style>

<body>
    <div class="container" style="margin-top:30px;">
      <div class="row mb-2 text-right">
          <h4>طریقه استفاده از نسخه IOS </h4>
      </div>
        <!-- Photo Grid -->
        <div class="row"> 
            <div class="column">
                <img class="clickable-image imgeGuide" onclick="zoomImage();" src="{{ url('/resources/assets/images/1.png')}}">
                <figcaption class="caption">گام اول </figcaption>
            </div>
            <div class="column">
                <img class="clickable-image imgeGuide" onclick="zoomImage();" src="{{ url('/resources/assets/images/2.png')}}">
                <figcaption class="caption">گام دوم  </figcaption>
            </div>
            <div class="column">
                <img class="clickable-image imgeGuide" onclick="zoomImage();" src="{{ url('/resources/assets/images/3.png')}}">
                <figcaption class="caption">گام سوم  </figcaption>
            </div>
        </div>
   </div>   

  <script>
      function zoomImage() {
      var termsToggles = document.querySelectorAll('.imgeGuide');
      for (var i = 0; i < termsToggles.length; i++) {
          termsToggles[i].addEventListener('click', toggleTerms);
      }
    }
    function toggleTerms() {
      this.classList.toggle('image-open');
    } 
</script>

</body>
</html>