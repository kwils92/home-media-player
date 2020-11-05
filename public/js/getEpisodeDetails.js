function getEpisodeDetails($epId, $epRating, $epNumber)
{
    var pElement = document.getElementById(`episode-details-${$epId}`);
    var episode = document.createTextNode(`Episode: ${$epNumber}`);  

    pElement.appendChild(episode);

    if($epRating == 0){
        pElement.innerHTML += `<i class="fas fa-star no-rating-star"></i>`; //plus equals to keep the episode append
    } else {
        for($ctr = 0; $ctr < $epRating; $ctr++){
            pElement.innerHTML += `<i class="fas fa-star c-star"></i>`;
        }
    }

    pElement.classList.add('detail-fade');
    pElement.classList.remove('hidden-li');
}

function hideEpisodeDetails($epId)
{
    var pElement = document.getElementById(`episode-details-${$epId}`);
    
    pElement.innerHTML='';
    pElement.classList.remove('detail-fade');
    pElement.classList.add('hidden-li');
}