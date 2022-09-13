jQuery(function($){



var quitStyleCount = 0;
var $iframeHead;

var twitterStylesTimer = window.setInterval(function(){

    $iframeHead = $("iframe#twitter-widget-1").contents().find('head');

    if( !$('#twitter-widget-styles', $iframeHead).length ){ //If our stylesheet does not exist tey to place it
        $iframeHead.append(`<link rel="stylesheet" href="${window.location.href}/wp-content/themes/rtc/css/twitter.css" id="twitter-widget-styles"><link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300&family=Cabin:ital,wght@0,400;0,600;0,700;1,400;1,700&display=swap" rel="stylesheet">`);
    }else if( $('#twitter-widget-styles', $iframeHead).length || ++quitStyleCount > 40){    //If stylesheet exists or we've been trying for too long then quit
        clearInterval(twitterStylesTimer);
    }

}, 200);

});



	