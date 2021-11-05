document.getElementById('show-episode-vp').addEventListener('canplay', autoPlayVideo,false);

function autoPlayVideo(e) {
    let urlString = new URL(location.href); 
    let isAutoPlay = urlString.searchParams.get("autoplay");
    
    if(isAutoPlay == "true"){
        document.getElementById('show-episode-vp').play(); 
    }
}