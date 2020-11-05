function changeTheme()
{
    document.onReady
    var themeIsDark = document.getElementById('theme-switch').innerHTML.includes("Dark"); 
    var elementText = document.getElementById('theme-switch');

    if(themeIsDark == true){
        elementText.innerHTML = "Enable Light Theme";
    } else {
        elementText.innerHTML = "Enable Dark Theme";
    }
}
