document.getElementById('show-episode-vp').addEventListener('ended', goToNextEpisode,false);

function goToNextEpisode(e) {
    if(document.getElementById('next-episode') !== null){
        let nextEpisodeURL = document.getElementById('next-episode').href;
        location.href = nextEpisodeURL + "?autoplay=true"; 
    }
}

