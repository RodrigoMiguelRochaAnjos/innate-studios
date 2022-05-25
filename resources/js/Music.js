class Music{
    title = "";
    src = "";
    duration = "";

    constructor(src,duration,title){
        this.src = src;
        this.duration=duration;
        this.title=title
    }

    getDuration(){
        return this.duration;
    }
    setDuration(duration){
        this.duration = duration;
    }
}