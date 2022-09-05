window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.classList.contains('home') && document.documentElement.scrollTop > 600 && window.innerWidth > 768) {
    document.getElementById("genesis-nav-primary").classList.add("animated-2", "slideInDown-2", "shrink");
document.getElementById("sticky-header-jump-fix").classList.add("animated-2", "slideInDown-2","shrink");
  } 
  else if (document.documentElement.scrollTop > 300 && window.innerWidth > 768) {
  	document.getElementById("genesis-nav-primary").classList.add("animated-2", "slideInDown-2", "shrink");
document.getElementById("sticky-header-jump-fix").classList.add("animated-2", "slideInDown-2","shrink");
  }
  else {
    document.getElementById("genesis-nav-primary").classList.remove("animated-2", "slideInDown-2", "shrink");
document.getElementById("sticky-header-jump-fix").classList.remove("animated-2", "slideInDown-2","shrink");
  }
}

 var hamburger = document.querySelector(".hamburger");
  var menuopen = document.querySelector(".nav-primary");
  var content = document.querySelector("body");
  hamburger.addEventListener("click", mobileMenu);
  
  function mobileMenu() {
   
    hamburger.classList.toggle("is-active");
    menuopen.classList.toggle("open");
    content.classList.toggle("blur");
  }
var list = document.getElementById("menu-main-menu").getElementsByTagName("a");
var i;
for (i = 0; i < list.length; i++) {
  list[i].onclick = mobileMenu;
}
function getCategory(e){
	document.location.href='?'+e.getAttribute('data-value');
}
window.addEventListener('load', function(){
	if(window.location.href.indexOf('?category=') > 0){
		var catID = document.getElementById("categories");
		catID.scrollIntoView(true);
	}
	
});
var elem = document.querySelector('.bl_category_container');
if (elem){
var infScroll = new InfiniteScroll( elem, {
  // options
  path: '.next-post',
  append: '.bl_category_list',
  history: false,
  scrollThreshold: false,
  hideNav: '.paged-navigation',
  status: '.page-load-status',
  button: '.view-more-button'
});
}
var shop = document.querySelector('.products');
if (shop){
/*	
var infScroll = new InfiniteScroll( shop, {
  // options
  path: '.next-post',
  append: '.product',
  history: false,
  scrollThreshold: false,
  hideNav: '.paged-navigation',
  status: '.page-load-status',
  button: '.view-more-button'
});
}*/
jQuery(function($){
	let sessionCat = sessionStorage.getItem('category');
	let sessionPos = sessionStorage.getItem('position');
	let sessionScroll = sessionStorage.getItem('scroll');
	function catchLinkId(){
		let listItems = $('li.product');
		listItems.each(function(){
			$(this).click(function(e){
				e.preventDefault();
				sessionStorage.setItem('scroll','#'+e.currentTarget.id);
				let URL = e.currentTarget.querySelector('.woocommerce-loop-product__link').getAttribute("href");
				console.log(URL);
				window.location.href = URL;
			});
		});
	}
	catchLinkId();
	if(sessionCat){
		$(function(){
			$('#response').fadeOut();
			let params = new URLSearchParams(sessionCat);
			let cat = params.get('categoryfilter');
			ajaxCat(sessionCat);
			$('#bl_select').val(cat);
			catchLinkId();
			
		});
	}
	else{
		moreButton();
	}
	function moreButton(){
		if(sessionPos){
			$(function() {
				sessionPos = sessionPos + "&position=true";
				ajaxMore(sessionPos);
				catchLinkId();
				
				$('#bl_next').click(function(){
					var numItems = $('.product').length;
					var cat = $('#bl_next').attr("value");
					var allData = "action=bl_next&listcount="+numItems+"&categoryfilter="+cat;
					sessionStorage.setItem('position',allData);
					ajaxMore(allData);
					catchLinkId();
				});
			});
			
		}
		else{
			$('#bl_next').click(function(){
			var numItems = $('.product').length;
			var cat = $('#bl_next').attr("value");
			var allData = "action=bl_next&listcount="+numItems+"&categoryfilter="+cat;
			sessionStorage.setItem('position',allData);
			ajaxMore(allData);
			catchLinkId();
			});
		}
	}
	function ajaxCat(filterData){
		$.ajax({
			url:"/wp-admin/admin-ajax.php",
			data:filterData, // form data
			type:"post", // POST
			success:function(data){
				$('#response').html(data); // insert data
				$('#response').fadeIn();
				moreButton();
			}
		});
		return false;
	}
	function ajaxMore(allData){
		$('.page-load-status').css("display","block");
		$('.loader-ellipse').css("display","block");
		$.ajax({
			url:"/wp-admin/admin-ajax.php",
			data:allData,
    			// form data
			type:"post", // POST
			
			success:function(data){
			$('.page-load-status').css("display","none");
			$('.loader-ellipse').css("display","none");
			$('#moreBooks').append(data); // insert data
			$('#moreBooks').fadeIn();
			catchLinkId();
			var numItemsRecount = $('.product').length;
			if((numItemsRecount%9)>0){
				$('#bl_next').hide();
				
			}
			if(sessionScroll){
				    $([document.documentElement, document.body]).animate({
				        scrollTop: $(sessionScroll).offset().top
				    }, 1000);
				    sessionStorage.removeItem('scroll');
				    sessionScroll = false;
			}
			}
		});
		return false;
	}

	$('#bl_select').change(function(){
		$('#moreBooks').empty();
		sessionStorage.removeItem('position');
		sessionPos = false;
		var filter = $('#filter');
		sessionStorage.setItem('category',filter.serialize());
		$('#response').fadeOut();
		filterData = filter.serialize();
		ajaxCat(filterData);
	});
	
});
}
window.addEventListener("load", function(event) {

var music = document.getElementById('music'); // id for audio element
if(music){
var duration = music.duration; // Duration of audio clip
var pButton = document.getElementById('pButton'); // play button
var playhead = document.getElementById('playhead'); // playhead
var timeline = document.getElementById('timeline'); // timeline
var podcast_duration = document.getElementById('podcast_duration');
podcast_duration.innerHTML = `Duration: ${seconds2time(Math.round(music.duration))}`;

// timeline width adjusted for playhead
var timelineWidth = timeline.offsetWidth - playhead.offsetWidth;

// play button event listenter
pButton.addEventListener("click", play);

// timeupdate event listener
music.addEventListener("timeupdate", timeUpdate, false);

// makes timeline clickable
timeline.addEventListener("click", function(event) {
    moveplayhead(event);
    music.currentTime = duration * clickPercent(event);
}, false);

// returns click as decimal (.77) of the total timelineWidth
function clickPercent(event) {
    return (event.clientX - getPosition(timeline)) / timelineWidth;

}

// makes playhead draggable
playhead.addEventListener('mousedown', mouseDown, false);
window.addEventListener('mouseup', mouseUp, false);

// Boolean value so that audio position is updated only when the playhead is released
var onplayhead = false;

// mouseDown EventListener
function mouseDown() {
    onplayhead = true;
    window.addEventListener('mousemove', moveplayhead, true);
    music.removeEventListener('timeupdate', timeUpdate, false);
}

// mouseUp EventListener
// getting input from all mouse clicks
function mouseUp(event) {
    if (onplayhead == true) {
        moveplayhead(event);
        window.removeEventListener('mousemove', moveplayhead, true);
        // change current time
        music.currentTime = music.duration * clickPercent(event);
        music.addEventListener('timeupdate', timeUpdate, false);
    }
    onplayhead = false;
}
// mousemove EventListener
// Moves playhead as user drags
function moveplayhead(event) {
    var newMargLeft = event.clientX - getPosition(timeline);

    if (newMargLeft >= 0 && newMargLeft <= timelineWidth) {
        playhead.style.marginLeft = newMargLeft + "px";
    }
    if (newMargLeft < 0) {
        playhead.style.marginLeft = "0px";
    }
    if (newMargLeft > timelineWidth) {
        playhead.style.marginLeft = timelineWidth + "px";
    }
}

// timeUpdate
// Synchronizes playhead position with current point in audio
function timeUpdate() {
    var playPercent = timelineWidth * (music.currentTime / duration);
    playhead.style.marginLeft = playPercent + "px";
    podcast_duration.innerHTML = `${seconds2time(Math.round(music.currentTime))}/${seconds2time(Math.round(music.duration))}`;
    if (music.currentTime == duration) {
        pButton.className = "";
        pButton.className = "play";
    }
}

//Play and Pause
function play() {
    // start music
    if (music.paused) {
        music.play();
        // remove play, add pause
        pButton.className = "";
        pButton.className = "pause";
    } else { // pause music
        music.pause();
        // remove pause, add play
        pButton.className = "";
        pButton.className = "play";
    }
}

// Gets audio file duration
music.addEventListener("canplaythrough", function() {
    duration = music.duration;
   
}, false);

// getPosition
// Returns elements left position relative to top-left of viewport
function getPosition(el) {
    return el.getBoundingClientRect().left;
    
}
function seconds2time (seconds) {
    var hours   = Math.floor(seconds / 3600);
    var minutes = Math.floor((seconds - (hours * 3600)) / 60);
    var second = seconds - (hours * 3600) - (minutes * 60);
    var time = "";

    if (hours != 0) {
      time = hours+":";
    }
    if (minutes != 0 || time !== "") {
      minutes = (minutes < 10 && time !== "") ? "0"+minutes : String(minutes);
      time += minutes+":";
    }
    if (time === "") {
      time = second+"s";
    }
    else {
      time += (second < 10) ? "0"+second : String(second);
    }
    return time;
}
}

/* DOMContentLoaded*/
});