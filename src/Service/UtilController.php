<?php

namespace App\Service;

class UtilController
{
    /**
     * Takes the filename from the uploaded file and splits it on the episode dash and the file format period 
     * so you are left with just the title itself.
     * Filename format for reference: 10-My_Show_Title.mp4
     */
    public function formatMediaTitle($rawTitle) : String
    {
        $rawTitle = str_replace('-', '.', $rawTitle);
        $splitTitle = explode('.', $rawTitle);
        $title = $splitTitle[1];

        return $title; 
    }

    /** 
     * Builds the filepath 
     */
    public function formatMediaFilePath($mediaCategory, $partialPath, $season, $show, $rawTitle) : String
    {
        $showTitle = $show->getTitle(); 
        $path = "{$partialPath}/{$mediaCategory}/{$showTitle}/Season_{$season}/{$rawTitle}";

        return $path; 
    }

    /** 
     * Cuts the episode off the front of the title 
     */
    public function determineEpisodeFromFile($rawTitle) : String
    {
        $splitTitle = explode('-', $rawTitle);
        $episode = $splitTitle[0];

        return $episode; 
    }

    /**
     * Gets the filetype by cutting the file format off the title.
     */
    public function determineFileTypeFromFile($rawTitle) : String
    {
        $splitTitle = explode('.', $rawTitle);
        $fileType = $splitTitle[1];

        return $fileType; 
    }

    //Add function for getting the show part (part a, b, etc) out of the title. 

    public function sendEmailNotification($ticket)
    {
        $msgBody = "A new request has been made for {$ticket->getRequest()}"; 
        mail($_ENV['ADMIN_EMAIL'], 'HDC - New Request Added', $msgBody);
    }
}