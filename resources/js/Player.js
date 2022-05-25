class Player{
    playing = false;
    audio = "";
    currentSong= 0;
    updateSong = true;
    currentSongDuration = 0;
    music = [];

    constructor(){
        this.audio = new Audio();
        this.audio.currentTime = this.getCookie('timePlayed');
    }
    setCookie(c_name, value, exdays){
        let exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        let c_value= escape(value) + ((exdays == null) ? `` : `; expires=${exdate.toUTCString()}`);
        document.cookie = `${c_name}=${c_value}`;
    }
    getCookie(c_name)
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
        setCookie('currentSong', player.currentSong);

    }

    stop(){
        this.playing = false;

        this.setCookie('timePlayed', this.audio.currentTime);
        this.audio.pause();
    }
    play(){
        if(this.audio.length != 0){
            if(this.updateSong){
                this.audio.src = this.music[this.currentSong].src;
                this.audio.currentTime = this.getCookie("timePlayed");

                this.currentSongDuration = this.music[this.currentSong].duration;
                
                this.updateSong = false;
            }
            this.playing= true;

            this.audio.play();
        }
    }
}