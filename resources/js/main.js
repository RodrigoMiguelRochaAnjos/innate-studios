let music = Array.from(document.querySelectorAll(".music-listing"));
let music_names = Array.from(document.querySelectorAll(".music-listing .title"));
let music_songs = Array.from(document.querySelectorAll(".music-listing .song"));

let playButton = document.getElementById("play");

player = new Player();


function setCookie(c_name, value, exdays){
    let exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    let c_value= escape(value) + ((exdays == null) ? `` : `; expires=${exdate.toUTCString()}`);
    document.cookie = `${c_name}=${c_value}`;
}

function getCookie(c_name)
{
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++)
    {
      x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
      y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
      x=x.replace(/^\s+|\s+$/g,"");
      if (x==c_name)
        {
        return unescape(y);
        }
      }
}

if((currentSong = getCookie("currentSong")) != null && (music_c = getCookie("music")) != null){
    let arr = JSON.parse(music_c);

    arr.forEach((element, index) => {
        player.addSong(element);
    });

    if(!!document.querySelector(".music-listing.selected")){
        document.querySelector(".music-listing.selected").classList.remove("selected");
    }
    if(music[currentSong] != null){
        music[currentSong].classList.add("selected");
    }
}


if(
    (timePlayed = getCookie("timePlayed")) != null &&
    (songDuration = getCookie("songDuration")) != null 
){
    // player.audio.currentTime = Math.round(timePlayed);
    // console.log(player.audio.currentTime);
    player.play();
}

window.onbeforeunload  = () =>{
    player.stop();
    
    if(player.playing){
        setCookie('music', JSON.stringify(player.music));
        setCookie('currentSong', player.currentSong);
        
        setCookie('timePlayed', player.audio.currentTime);
        setCookie('songDuration', player.currentSongDuration);
    }
    player.currentTime = player.audio.currentTime;
}

music_songs.forEach((element, index) => {
    song = new Music(`${element.value.trim()}`, "00:00", "Music");
    element.remove();

    song.title = music_names[index];

    music[index].addEventListener('click', () => {
        if(!!document.querySelector(".music-listing.selected")){
            document.querySelector(".music-listing.selected").classList.remove("selected");
        }
        music[index].classList.add("selected");

        player.chooseSong(index);
        document.getElementById("progress").style.width= `0%`; 
    });
    
    player.addSong(song);
});

document.getElementById("play").addEventListener('click', ()=> {
    if(player.playing){
        playButton.src= "/resources/img/play.png";

        player.stop();
    }else{
        playButton.src= "/resources/img/pause.png";

        player.play();
    }
});


player.audio.addEventListener('timeupdate', updateProgress);

function updateProgress(e){
    const {duration, currentTime} = e.srcElement;
    const progress = (currentTime / duration) * 100;

    player.currentTime=currentTime;
    player.currentSongDuration=duration;
    document.getElementById("progress").style.width= `${progress}%`; 
}