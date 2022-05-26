class Player{
    playing = false;
    audio = "";
    currentSong= 0;
    updateSong = true;
    currentSongDuration = 0;
    music = [];

    constructor(){
        this.audio = new Audio();
    }

    async addSong(music){
        this.audio.src = music.src;

        let duration = this.audio.duration
        var seconds = this.audio.duration % 60;
        var foo = duration - seconds;
        var minutes = foo / 60;

        if(seconds < 10){
            seconds = "0" + seconds.toString();
        }
        music.duration = minutes + ":" + Math.round(seconds);


        this.music.push( music );
        this.currentSongDuration = this.music[this.currentSong].duration;
        
    }

    chooseSong(index){
        this.currentSong = index;
        this.updateSong= true;

        this.currentSongDuration = this.music[this.currentSong].duration;
        
        playButton.src= "/resources/img/play.png";

        player.stop();
    }

    stop(){
        this.playing = false;

        this.audio.pause();
    }
    play(){
        if(this.audio.length != 0){
            if(this.updateSong){
                this.audio.src = this.music[this.currentSong].src;

                this.currentSongDuration = this.music[this.currentSong].duration;
                
                this.updateSong = false;
            }
            this.playing= true;

            this.audio.play();
        }
    }
}