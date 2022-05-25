

let listing = Array.from(document.querySelectorAll(".music-listing"));
let selected_title = document.querySelector(".selected .title").innerHTML;

let selected_song = document.querySelector(".selected .song");

let audio = document.getElementById("audio");
let playButton = document.getElementById("play");

audio.src = selected_song.value;

listing.forEach((item, index)=>{
    item.addEventListener('click', select);
});


function select(e){
    document.querySelector(".selected").classList.remove("selected");
    this.classList.add("selected");

    selected_song = document.querySelector(".selected .song");
    selected_title = document.querySelector(".selected .title").innerHTML;

    audio.src = selected_song.value;
    document.getElementById('song-playing').innerHTML= "";
    if(playButton.classList.contains("playing")){
        playButton.classList.remove("playing");
        playButton.src= "/resources/img/play.png";
    }
}


playButton.addEventListener('click', () => {
    if(playButton.classList.contains("playing")){
        playButton.classList.remove("playing");
        playButton.src= "/resources/img/play.png";

        audio.pause();
        document.getElementById('song-playing').innerHTML= "";
    }else {
        playButton.classList.add("playing");
        playButton.src= "/resources/img/pause.png";

        audio.play();
        document.getElementById('song-playing').innerHTML= selected_title;
    }
});
audio.addEventListener('timeupdate', updateProgress);
audio.addEventListener('loadedmetadata', setDuration);

function updateProgress(e){
    const {duration, currentTime} = e.srcElement;
    const progress = (currentTime / duration) * 100;

    document.getElementById("progress").style.width= `${progress}%`; 
}

function setDuration(e){
    
}