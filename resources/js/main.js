let music = Array.from(document.querySelectorAll(".music-listing"));
let music_names = Array.from(document.querySelectorAll(".music-listing .title"));
let music_songs = Array.from(document.querySelectorAll(".music-listing .song"));

let playButton = document.getElementById("play");

player = new Player();

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
        document.getElementById("progress").style.width= "0%";
        playButton.src= "/resources/img/pause.png";

        player.play();
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