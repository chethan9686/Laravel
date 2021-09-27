<!DOCTYPE html>
<html lang="en">
<head>
  <title>Wings Events | HRM</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('wings-favicon.png')}}" type="image/x-icon">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
@media (min-width:320px)  { /* smartphones, iPhone, portrait 480x320 phones */
    
body {
  background-color: #fff;
}


#loading-wrapper {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
}

#loading-text {
  display: block;
  position: absolute;
  top: 38%;
  left: 35%;
  color: #fff;
  width: 100px;
  height: 30px;
  margin: -11px 0 0 -45px;
  text-align: center;
  font-family: 'Impact', sans-serif;
  font-size: 32px;
}

#loading-content {
  display: block;
  position: relative;
  left: 50%;
  top: 40%;
  width: 300px;
  height: 300px;
  margin: -85px 0 0 -150px;
  border: 3px solid #F00;
}

#loading-content:after {
  content: "";
  position: absolute;
  border: 4px solid #0F0;
  left: 15px;
  right: 15px;
  top: 15px;
  bottom: 15px;
}

#loading-content:before {
  content: "";
  position: absolute;
  border: 3px solid #00F;
  left: 5px;
  right: 5px;
  top: 5px;
  bottom: 5px;
}

#loading-content {
  border: 3px solid transparent;
  border-top-color: #be533b;
  border-bottom-color: #be533b;
  border-radius: 50%;
  -webkit-animation: loader 2s linear infinite;
  -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 2s linear infinite;
}

#loading-content:before {
  border: 3px solid transparent;
  border-top-color: #222;
  border-bottom-color: #222;
  border-radius: 50%;
  -webkit-animation: loader 3s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 3s linear infinite;
}

#loading-content:after {
  border: 3px solid transparent;
  border-top-color: #fab27d;
  border-bottom-color: #fab27d;
  border-radius: 50%;
  -webkit-animation: loader 1.5s linear infinite;
  animation: loader 1.5s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
}

@-webkit-keyframes loaders {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

#content-wrapper {
  color: #FFF;
  position: fixed;
  left: 0;
  top: 20px;
  width: 100%;
  height: 100%;
}

#header
{
  width: 800px;
  margin: 0 auto;
  text-align: center;
  height: 100px;
  background-color: #666;
}

#content
{
  width: 800px;
  height: 1000px;
  margin: 0 auto;
  text-align: center;
  background-color: #888;
}
}
@media (min-width:481px)  { /* portrait e-readers (Nook/Kindle), smaller tablets @ 600 or @ 640 wide. */ 

body {
  background-color: #fff;
}


#loading-wrapper {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
}

#loading-text {
  display: block;
  position: absolute;
  top: 38%;
  left: 35%;
  color: #fff;
  width: 100px;
  height: 30px;
  margin: -11px 0 0 -45px;
  text-align: center;
  font-family: 'Impact', sans-serif;
  font-size: 32px;
}

#loading-content {
  display: block;
  position: relative;
  left: 50%;
  top: 40%;
  width: 300px;
  height: 300px;
  margin: -85px 0 0 -150px;
  border: 3px solid #F00;
}

#loading-content:after {
  content: "";
  position: absolute;
  border: 4px solid #0F0;
  left: 15px;
  right: 15px;
  top: 15px;
  bottom: 15px;
}

#loading-content:before {
  content: "";
  position: absolute;
  border: 3px solid #00F;
  left: 5px;
  right: 5px;
  top: 5px;
  bottom: 5px;
}

#loading-content {
  border: 3px solid transparent;
  border-top-color: #be533b;
  border-bottom-color: #be533b;
  border-radius: 50%;
  -webkit-animation: loader 2s linear infinite;
  -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 2s linear infinite;
}

#loading-content:before {
  border: 3px solid transparent;
  border-top-color: #222;
  border-bottom-color: #222;
  border-radius: 50%;
  -webkit-animation: loader 3s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 3s linear infinite;
}

#loading-content:after {
  border: 3px solid transparent;
  border-top-color: #fab27d;
  border-bottom-color: #fab27d;
  border-radius: 50%;
  -webkit-animation: loader 1.5s linear infinite;
  animation: loader 1.5s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
}

@-webkit-keyframes loaders {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

#content-wrapper {
  color: #FFF;
  position: fixed;
  left: 0;
  top: 20px;
  width: 100%;
  height: 100%;
}

#header
{
  width: 800px;
  margin: 0 auto;
  text-align: center;
  height: 100px;
  background-color: #666;
}

#content
{
  width: 800px;
  height: 1000px;
  margin: 0 auto;
  text-align: center;
  background-color: #888;
}   
}
@media (min-width:641px)  { /* portrait tablets, portrait iPad, landscape e-readers, landscape 800x480 or 854x480 phones */ 
        
body {
  background-color: #fff;
}


#loading-wrapper {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
}

#loading-text {
  display: block;
  position: absolute;
  top: 38%;
  left: 35%;
  color: #fff;
  width: 100px;
  height: 30px;
  margin: -11px 0 0 -45px;
  text-align: center;
  font-family: 'Impact', sans-serif;
  font-size: 32px;
}

#loading-content {
  display: block;
  position: relative;
  left: 50%;
  top: 40%;
  width: 300px;
  height: 300px;
  margin: -85px 0 0 -150px;
  border: 3px solid #F00;
}

#loading-content:after {
  content: "";
  position: absolute;
  border: 4px solid #0F0;
  left: 15px;
  right: 15px;
  top: 15px;
  bottom: 15px;
}

#loading-content:before {
  content: "";
  position: absolute;
  border: 3px solid #00F;
  left: 5px;
  right: 5px;
  top: 5px;
  bottom: 5px;
}

#loading-content {
  border: 3px solid transparent;
  border-top-color: #be533b;
  border-bottom-color: #be533b;
  border-radius: 50%;
  -webkit-animation: loader 2s linear infinite;
  -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 2s linear infinite;
}

#loading-content:before {
  border: 3px solid transparent;
  border-top-color: #222;
  border-bottom-color: #222;
  border-radius: 50%;
  -webkit-animation: loader 3s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 3s linear infinite;
}

#loading-content:after {
  border: 3px solid transparent;
  border-top-color: #fab27d;
  border-bottom-color: #fab27d;
  border-radius: 50%;
  -webkit-animation: loader 1.5s linear infinite;
  animation: loader 1.5s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
}

@-webkit-keyframes loaders {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

#content-wrapper {
  color: #FFF;
  position: fixed;
  left: 0;
  top: 20px;
  width: 100%;
  height: 100%;
}

#header
{
  width: 800px;
  margin: 0 auto;
  text-align: center;
  height: 100px;
  background-color: #666;
}

#content
{
  width: 800px;
  height: 1000px;
  margin: 0 auto;
  text-align: center;
  background-color: #888;
}
}
@media (min-width:961px)  { /* tablet, landscape iPad, lo-res laptops ands desktops */ 
    
body {
  background-color: #fff;
}


#loading-wrapper {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
}

#loading-text {
  display: block;
  position: absolute;
  top: 38%;
  left: 47%;
  color: #fff;
  width: 100px;
  height: 30px;
  margin: -11px 0 0 -45px;
  text-align: center;
  font-family: 'Impact', sans-serif;
  font-size: 32px;
}

#loading-content {
  display: block;
  position: relative;
  left: 50%;
  top: 40%;
  width: 300px;
  height: 300px;
  margin: -85px 0 0 -150px;
  border: 3px solid #F00;
}

#loading-content:after {
  content: "";
  position: absolute;
  border: 4px solid #0F0;
  left: 15px;
  right: 15px;
  top: 15px;
  bottom: 15px;
}

#loading-content:before {
  content: "";
  position: absolute;
  border: 3px solid #00F;
  left: 5px;
  right: 5px;
  top: 5px;
  bottom: 5px;
}

#loading-content {
  border: 3px solid transparent;
  border-top-color: #be533b;
  border-bottom-color: #be533b;
  border-radius: 50%;
  -webkit-animation: loader 2s linear infinite;
  -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 2s linear infinite;
}

#loading-content:before {
  border: 3px solid transparent;
  border-top-color: #222;
  border-bottom-color: #222;
  border-radius: 50%;
  -webkit-animation: loader 3s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 3s linear infinite;
}

#loading-content:after {
  border: 3px solid transparent;
  border-top-color: #fab27d;
  border-bottom-color: #fab27d;
  border-radius: 50%;
  -webkit-animation: loader 1.5s linear infinite;
  animation: loader 1.5s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
}

@-webkit-keyframes loaders {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

#content-wrapper {
  color: #FFF;
  position: fixed;
  left: 0;
  top: 20px;
  width: 100%;
  height: 100%;
}

#header
{
  width: 800px;
  margin: 0 auto;
  text-align: center;
  height: 100px;
  background-color: #666;
}

#content
{
  width: 800px;
  height: 1000px;
  margin: 0 auto;
  text-align: center;
  background-color: #888;
}
    
}
@media (min-width:1025px) { /* big landscape tablets, laptops, and desktops */
     
body {
  background-color: #fff;
}


#loading-wrapper {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
}

#loading-text {
  display: block;
  position: absolute;
  top: 40%;
  left: 49%;
  color: #fff;
  width: 100px;
  height: 30px;
  margin: -11px 0 0 -64px;
  text-align: center;
  font-family: 'Impact', sans-serif;
  font-size: 32px;
}

#loading-content {
  display: block;
  position: relative;
  left: 50%;
  top: 40%;
  width: 340px;
  height: 340px;
  margin: -85px 0 0 -150px;
  border: 3px solid #F00;
}

#loading-content:after {
  content: "";
  position: absolute;
  border: 4px solid #0F0;
  left: 15px;
  right: 15px;
  top: 15px;
  bottom: 15px;
}

#loading-content:before {
  content: "";
  position: absolute;
  border: 3px solid #00F;
  left: 5px;
  right: 5px;
  top: 5px;
  bottom: 5px;
}

#loading-content {
  border: 3px solid transparent;
  border-top-color: #be533b;
  border-bottom-color: #be533b;
  border-radius: 50%;
  -webkit-animation: loader 2s linear infinite;
  -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 2s linear infinite;
}

#loading-content:before {
  border: 3px solid transparent;
  border-top-color: #222;
  border-bottom-color: #222;
  border-radius: 50%;
  -webkit-animation: loader 3s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 3s linear infinite;
}

#loading-content:after {
  border: 3px solid transparent;
  border-top-color: #fab27d;
  border-bottom-color: #fab27d;
  border-radius: 50%;
  -webkit-animation: loader 1.5s linear infinite;
  animation: loader 1.5s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
}

@-webkit-keyframes loaders {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

#content-wrapper {
  color: #FFF;
  position: fixed;
  left: 0;
  top: 20px;
  width: 100%;
  height: 100%;
}

#header
{
  width: 800px;
  margin: 0 auto;
  text-align: center;
  height: 100px;
  background-color: #666;
}

#content
{
  width: 800px;
  height: 1000px;
  margin: 0 auto;
  text-align: center;
  background-color: #888;
}
}
@media (min-width:1281px) { /* hi-res laptops and desktops */ 
     
body {
  background-color: #fff;
}


#loading-wrapper {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
}

#loading-text {
  display: block;
  position: absolute;
  top: 38%;
  left: 46%;
  color: #fff;
  width: 100px;
  height: 30px;
  margin: -11px 0 0 -45px;
  text-align: center;
  font-family: 'Impact', sans-serif;
  font-size: 32px;
}

#loading-content {
  display: block;
  position: relative;
  left: 50%;
  top: 40%;
  width: 300px;
  height: 300px;
  margin: -85px 0 0 -150px;
  border: 3px solid #F00;
}

#loading-content:after {
  content: "";
  position: absolute;
  border: 4px solid #0F0;
  left: 15px;
  right: 15px;
  top: 15px;
  bottom: 15px;
}

#loading-content:before {
  content: "";
  position: absolute;
  border: 3px solid #00F;
  left: 5px;
  right: 5px;
  top: 5px;
  bottom: 5px;
}

#loading-content {
  border: 3px solid transparent;
  border-top-color: #be533b;
  border-bottom-color: #be533b;
  border-radius: 50%;
  -webkit-animation: loader 2s linear infinite;
  -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 2s linear infinite;
}

#loading-content:before {
  border: 3px solid transparent;
  border-top-color: #222;
  border-bottom-color: #222;
  border-radius: 50%;
  -webkit-animation: loader 3s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 3s linear infinite;
}

#loading-content:after {
  border: 3px solid transparent;
  border-top-color: #fab27d;
  border-bottom-color: #fab27d;
  border-radius: 50%;
  -webkit-animation: loader 1.5s linear infinite;
  animation: loader 1.5s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
}

@-webkit-keyframes loaders {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

#content-wrapper {
  color: #FFF;
  position: fixed;
  left: 0;
  top: 20px;
  width: 100%;
  height: 100%;
}

#header
{
  width: 800px;
  margin: 0 auto;
  text-align: center;
  height: 100px;
  background-color: #666;
}

#content
{
  width: 800px;
  height: 1000px;
  margin: 0 auto;
  text-align: center;
  background-color: #888;
}
@media (min-width:1920px) { /* hi-res laptops and desktops */ 
     
body {
  background-color: #fff;
}


#loading-wrapper {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
}

#loading-text {
  display: block;
  position: absolute;
  top: 38%;
  left: 46%;
  color: #fff;
  width: 100px;
  height: 30px;
  margin: -11px 0 0 -28px;
  text-align: center;
  font-family: 'Impact', sans-serif;
  font-size: 32px;
}

#loading-content {
  display: block;
  position: relative;
  left: 50%;
  top: 40%;
  width: 300px;
  height: 300px;
  margin: -85px 0 0 -150px;
  border: 3px solid #F00;
}

#loading-content:after {
  content: "";
  position: absolute;
  border: 4px solid #0F0;
  left: 15px;
  right: 15px;
  top: 15px;
  bottom: 15px;
}

#loading-content:before {
  content: "";
  position: absolute;
  border: 3px solid #00F;
  left: 5px;
  right: 5px;
  top: 5px;
  bottom: 5px;
}

#loading-content {
  border: 3px solid transparent;
  border-top-color: #be533b;
  border-bottom-color: #be533b;
  border-radius: 50%;
  -webkit-animation: loader 2s linear infinite;
  -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 2s linear infinite;
}

#loading-content:before {
  border: 3px solid transparent;
  border-top-color: #222;
  border-bottom-color: #222;
  border-radius: 50%;
  -webkit-animation: loader 3s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
  animation: loader 3s linear infinite;
}

#loading-content:after {
  border: 3px solid transparent;
  border-top-color: #fab27d;
  border-bottom-color: #fab27d;
  border-radius: 50%;
  -webkit-animation: loader 1.5s linear infinite;
  animation: loader 1.5s linear infinite;
    -moz-animation: loader 2s linear infinite;
  -o-animation: loader 2s linear infinite;
}

@-webkit-keyframes loaders {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

#content-wrapper {
  color: #FFF;
  position: fixed;
  left: 0;
  top: 20px;
  width: 100%;
  height: 100%;
}

#header
{
  width: 800px;
  margin: 0 auto;
  text-align: center;
  height: 100px;
  background-color: #666;
}

#content
{
  width: 800px;
  height: 1000px;
  margin: 0 auto;
  text-align: center;
  background-color: #888;
}
}
</style>
<body>
    <div id="loading-wrapper">
      <div id="loading-text">
          <img src="{{asset('logo.png')}}"></a>
      </div>
      <div id="loading-content"></div>
    </div>
<script>
    setTimeout('Redirect()', 3000);
function Redirect() 
{  
    window.location="http://localhost:8000/home"; 
} 
</script>
</body>
</html>