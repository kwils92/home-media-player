<?php

namespace App\Service;

use App\Repository\ShowsRepository;

class UtilController
{
    public function formatMediaTitle($rawTitle) : String
    {
        $rawTitle = str_replace('-', '.', $rawTitle);
        $splitTitle = explode('.', $rawTitle);
        $title = $splitTitle[1];

        return $title; 
    }

    public function formatMediaFilePath($mediaCategory, $partialPath, $season, $show, $rawTitle) : String
    {
        $showTitle = $show->getTitle(); 
        $path = "{$partialPath}/{$mediaCategory}/{$showTitle}/Season_{$season}/{$rawTitle}";

        return $path; 
    }

    public function determineEpisodeFromFile($rawTitle) : String
    {
        $splitTitle = explode('-', $rawTitle);
        $episode = $splitTitle[0];

        return $episode; 
    }

    public function determineFileTypeFromFile($rawTitle) : String
    {
        $splitTitle = explode('.', $rawTitle);
        $fileType = $splitTitle[1];

        return $fileType; 
    }

    //Add function for getting the show part out of the title. 
}