document.getElementById('show-episode-vp').addEventListener('ended',myHandler,false);
function myHandler(e) {
    let nextEpisodeURL = document.getElementById('next-episode').href; 
    location.href = nextEpisodeURL; 
}