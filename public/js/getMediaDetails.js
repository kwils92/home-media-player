function getMediaDetails(showTitle, showId)
{
    var pElement = document.getElementById(`js-show-desc-${ showId }`);

    if(pElement.innerText === ''){
        var xhr = new XMLHttpRequest(); 

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                showDescription(JSON.parse(xhr.responseText), pElement);
            } else {
                console.log('Unable to fetch results from omdapi');
            }
        }

        xhr.open('GET', `http://www.omdbapi.com/?apikey=25302863&t=${ showTitle }`);
        xhr.send();
    }
}

function showDescription(response, pElement)
{
    var text = typeof response.Plot === 'undefined' ? document.createTextNode('No description available') : document.createTextNode(response.Plot);

    pElement.appendChild(text);
    pElement.classList.add('a-fade-in');
}