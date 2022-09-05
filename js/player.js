yt_players = document.querySelectorAll('.player.youtube');
vm_players = document.querySelectorAll('.player.vimeo');

var allPlayers=[];

if(yt_players.length>0){
    var tag = document.createElement("script");
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName("script")[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

if(vm_players.length>0){
    
    vm_players.forEach(vmplayer=>{
        var player = new Vimeo.Player(vmplayer);
        player.ready().then(onPlayerReady(player));
        player.on('pause',()=>onPlayerPause(player))
        allPlayers.push(player);
    });
}
function onYouTubeIframeAPIReady(){   
    yt_players.forEach(ytplayer=>{
        const id = ytplayer.dataset.id;
        var player = new YT.Player(ytplayer,{
            videoId:id,
            events:{
                'onStateChange': onPlayerPause,
                'onReady': onPlayerReady,
            }
        });
        allPlayers.push(player);
    })
}
function onPlayerPause(element){
    if(element.data == 2){
        element.target.h.parentNode.classList.remove('playing');
    }
    else if(element.element){
        element.element.parentNode.classList.remove('playing')
    }
}

function onPlayerReady(element){
    let player;
    let playerElement;
    if(element.target){
        player = element.target;
        playerElement = player.h;
    }
    else if(element.element){
        player = element;
        playerElement = element.element;
    }
    
    playerElement.parentNode.classList.add('ready');
    playerElement.parentNode.addEventListener('click',(event)=>{
        if(event.target!=playerElement){
            if(typeof player.playVideo === 'function'){
                player.playVideo();
            }
            else{
                player.play()
            }
            event.currentTarget.classList.add('playing');
            allPlayers.forEach(eachPlayer=>{
                if(eachPlayer!=player){
                    if(typeof eachPlayer.pauseVideo === 'function'){
                        eachPlayer.pauseVideo();
                    }
                    else{
                        eachPlayer.pause();
                    }
                    
                }
            });
        }
    })
}

