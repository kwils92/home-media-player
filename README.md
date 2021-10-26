# HOME MEDIA PLAYER (MOVIE HOTEL)

View demo on Heroku: https://safe-journey-94724.herokuapp.com/

*NOTE: You will not actually be able to watch the videos. I think that would be illegal?*

## SUMMARY
This project was built to allow those connected to my home network to access my movies and shows on their devices. Digital copies of our media are uploaded into a MySQL database via the "batch uploader" that is available in the application. 

The project was built mobile-first, as we can simply use our DVDs to watch on the TV, but no so much on our tablets and phones. However, the desktop version has been cleaned up and looks about as good as the mobile version. 

It uses the [OMDb API](https://www.omdbapi.com/) to populate show and movie data. 

## HOW TO FORMAT DATA

The file structure for **Shows** should be in this format: 

Videos/Shows/Afro_Samurai/Season_1/1-Revenge.mp4 

Titles of **Shows** also have rules. There *cannot* be spaces, apostrophes, quotes, hyphens, or periods. The hyphen is used to split the episode title from the episode number, and the period separates the title from the file format.

The file structure for **Movies** is similar, as are the titles: 

Videos/Movies/A_Goofy_Movie.mp4 

Movie titles must have no spaces and apostrophes. 



## HOW TO UPLOAD DATA 

There were two major problems that I dealt with while trying to get data into the database. The first, obviously, is that it's time consuming to upload hundreds of individual files manually. My solution was to use the following PowerShell script to print the name of every video to a text file.

`dir -n > _list.txt`

That text file is then submitted via form from inside the application, and the data from that file is parsed and inserted into the database. The logic can be viewed in src/Service/UtilController.php. But to explain it briefly, all of the data required for an upload is included in the title of the video itself--like an episode number--that is split and inserted accordingly. 

There are, it should be noted, two separate batch uploads. The first for Shows and another for Movies, as the former has Episodes that need to be sorted and the latter does not. 

*NOTE: There currently isn't a elegant way for this application to crash. If your upload fails, it will crash. There is an open issue about it... I'll get to it* 

## CONCLUSION

That's about it. If you have an questions, you can email me at kenneth.c.wilson92@gmail.com. Thanks for reading! 