<?php

namespace App\Service;

class UtilController
{
    /**
     * Takes the filename from the uploaded file and splits it on the episode dash and the file format period 
     * so you are left with just the title itself.
     * Filename format for Shows: 10-My_Show_Title.mp4
     * Filename format for Movies: My_Movie_Title.mp4
     */
    public function formatMediaTitle($rawTitle) : String
    {
        $rawTitle = str_replace('-', '.', $rawTitle);
        $splitTitle = explode('.', $rawTitle);

        $title = sizeof($splitTitle) == 3 ? $splitTitle[1] : $splitTitle[0];
        
        return $title; 
    }

    /** 
     * Builds the filepath 
     */
    public function formatMediaFilePath($mediaCategory, $partialPath, $season, $media, $rawTitle) : String
    {
        if($mediaCategory == 'Shows'){
            $showTitle = $media->getTitle();
            $path = "{$partialPath}/{$mediaCategory}/{$showTitle}/Season_{$season}/{$rawTitle}";
        } else {
            $path = "{$partialPath}/{$mediaCategory}/{$rawTitle}";
        }

        return $path; 
    }

    /** 
     * Cuts the episode off the front of the title 
     */
    public function determineEpisodeFromFile($rawTitle) : Int
    {
        $splitTitle = explode('-', $rawTitle);
        $episode = (int)$splitTitle[0];

        return $episode; 
    }

    /**
     * Gets the filetype by cutting the file format off the title.
     */
    public function determineFileTypeFromFile($mediaType, $rawTitle) : String
    {
        $splitTitle = explode('.', $rawTitle);
        
        if($mediaType === 'Shows'){
            $fileType = $splitTitle[1];
        } else {
            $fileType = $splitTitle[1];
        }

        return $fileType; 
    }

    //Add function for getting the show part (part a, b, etc) out of the title. 

    public function sendEmailNotification($ticket) : void
    {
        $msgBody = "A new request has been made for {$ticket->getRequest()}"; 

        mail($_ENV['ADMIN_EMAIL'], 'HDC - New Request Added', $msgBody);
    }

    public function spliceArticleForSorting($title)
    {
        $article = "";
        $sortingTitle = "";


        $ARTICLE_THE = substr($title, 0, 4); // "The_"
        $ARTICLE_AN = substr($title, 0, 3);  // "An_"
        $ARTICLE_A = substr($title, 0, 2);   // "A_" 

        $TITLE_MINUS_THE = substr($title, 4); 
        $TITLE_MINUS_AN = substr($title, 3);
        $TITLE_MINUS_A = substr($title, 2);
 
        if($ARTICLE_THE == 'The_'){
            $article = substr($ARTICLE_THE, 0, 3);
            $sortingTitle = "{$TITLE_MINUS_THE},_{$article}";
        } elseif ($ARTICLE_AN == 'An_') {
            $article = substr($ARTICLE_THE, 0, 2); 
            $sortingTitle = "{$TITLE_MINUS_AN},_{$ARTICLE_AN}"; 
        } elseif($ARTICLE_A == 'A_') {
            $article = substr($ARTICLE_THE, 0, 1); 
            $sortingTitle = "{$TITLE_MINUS_A},_{$ARTICLE_A}";
        } else {
            $sortingTitle = $title; 
        }
 
        return $sortingTitle; 
    }
}