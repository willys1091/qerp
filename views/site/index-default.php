<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\MsSupplier;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
hr {
    max-width: 50px;
    border-width: 3px;
    border-color: #58c514;
    margin-left: calc(50% - 25px);
}

@font-face {
    font-family: 'Digital-7';
    src: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/184191/Digital-7.eot?#iefix') format('embedded-opentype'),  url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/184191/Digital-7.woff') format('woff'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/184191/Digital-7.ttf')  format('truetype'), url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/184191/Digital-7.svg#Digital-7') format('svg');font-weight: normal;font-style: normal;}
::selection{background:#333;}::-moz-selection{background:#111;}
*,html{margin:0;}
body{background:#333}
figure{width:210px;height:210px;position:absolute;top:200px;left:50%;margin-top:-105px;margin-left:-105px;transform-style: preserve-3d;-webkit-transform-style: preserve-3d;-webkit-transform: rotateX(-35deg) rotateY(45deg);transform: rotateX(-35deg) rotateY(45deg);transition:2s;}
figure:hover{-webkit-transform:rotateX(-50deg) rotateY(45deg);transform:rotateX(-50deg) rotateY(45deg);}
.face{width:100%;height:100%;position:absolute;-webkit-transform-origin: center;transform-origin: center;background:#000;text-align:center;}
p.clock{font-size:180px;font-family: 'Digital-7';margin-top:20px;color:#2982FF;text-shadow:0px 0px 5px #000;-webkit-animation:color 10s infinite;animation:color 10s infinite;line-height:180px;}
.front{-webkit-transform: translate3d(0, 0, 105px);transform: translate3d(0, 0, 105px);background:#111;}
.left{-webkit-transform: rotateY(-90deg) translate3d(0, 0, 105px);transform: rotateY(-90deg) translate3d(0, 0, 105px);background:#151515;}
.top{-webkit-transform: rotateX(90deg) translate3d(0, 0, 105px);transform: rotateX(90deg) translate3d(0, 0, 105px);background:#222;}

@keyframes color{
    0%{color:#2982ff;text-shadow:0px 0px 5px #000;}
    50%{color:#cc4343;text-shadow:0px 0px 5px #ff0000;}
}
@-webkit-keyframes color{
    0%{color:#2982ff;text-shadow:0px 0px 5px #000;}
    50%{color:#cc4343;text-shadow:0px 0px 5px #ff0000;}
}
</style>
<div class="row">
    <div class="col-lg-12 mx-auto">
        <h1 class="text-uppercase text-center">
            <strong>WELCOME <?= $user->fullName ?></strong>
        </h1>
        <hr>
    </div>
    <div class="col-lg-12 mx-auto text-center">
        <p class="text-faded mb-5">This is your default Homepage, if you found that this is incorrect please contact Site Administrator or Company Director,
        to request for dashboard change</p>
    </div>
    <div class="col-lg-12 mx-auto">
        <figure>
            <div class="face top"><p class="clock" id="s"></p></div>
            <div class="face front"><p class="clock" id="m"></p></div>
            <div class="face left"><p class="clock" id="h"></p></div>
        </figure>
    </div>
</div>
<script>
function date_time(id)
{
    date = new Date;
    h = date.getHours();
    if(h<10)
    {
            h = "0"+h;
    }
    m = date.getMinutes();
    if(m<10)
    {
            m = "0"+m;
    }
    s = date.getSeconds();
    if(s<10)
    {
            s = "0"+s;
    }
    document.getElementById("s").innerHTML = ''+s;
    document.getElementById("m").innerHTML = ''+m;
    document.getElementById("h").innerHTML = ''+h;
    setTimeout('date_time("'+"s"+'");','1000');
    return true;
}
window.onload = date_time('s');
</script>