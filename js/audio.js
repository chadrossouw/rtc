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
});