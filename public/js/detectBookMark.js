window.addEventListener('load', detectBookMark, false);

/**
 * This function detects bookmarks on the Shows page only. It is used to display the currently bookmarked episode next to the name. 
 */
function detectBookMark(){
    let urlString = location.href.split("/");
    let showId = urlString[4];

    for(var key in localStorage){
        if(key == 'hdc-bookmark-' + showId){
            document.getElementById('bookmark-' + localStorage.getItem(key)).classList.remove("m-hidden");
        }
    }
}

/**
 * This function fills in the bookmark button if the current episode IS bookmarked in the ShowEpisodes videoplayer page. 
 * @param {*} episodeId 
 * @param {*} showTitleId 
 */
function detectBookMarkOnPage(episodeId, showTitleId){
    let bookmark = document.getElementById('vPlayer-bookmark');

    for(var key in localStorage){
        if(key == 'hdc-bookmark-' + showTitleId && localStorage.getItem(key) == episodeId){
            bookmark.classList.remove('far', 'fa-bookmark');
            bookmark.classList.add('fas', 'fa-bookmark');
        }
    }
}