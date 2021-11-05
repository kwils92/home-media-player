/* This file will have two functions. First will be the one to make an episode Bookmarkable. 
the second will be the one to detect the bookmark */

function bookMarkEpisode(episodeId, showTitle){
    let bookmark = document.getElementById('vPlayer-bookmark');
    localStorage.setItem('hdc-bookmark-' + showTitle, episodeId);

    if(bookmark.classList.contains('far')){
        bookmark.classList.remove('far', 'fa-bookmark');
        bookmark.classList.add('fas', 'fa-bookmark');
    } else {
        bookmark.classList.remove('fas', 'fa-bookmark');
        bookmark.classList.add('far', 'fa-bookmark');

        localStorage.removeItem('hdc-bookmark-' + showTitle);
    }
}