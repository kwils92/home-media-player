<?php

namespace App\Service;

use App\Repository\ShowsRepository;

class UtilController
{
    public function formatMediaTitle($rawTitle)
    {
        $rawTitle = str_replace('-', '.', $rawTitle);
        $splitTitle = explode('.', $rawTitle);
        $title = $splitTitle[1];

        return $title; 
    }

    public function formatMediaFilePath($mediaCategory, $partialPath, $season, $show, $rawTitle)
    {
        $showTitle = $show->getTitle(); 
        $path = "{$partialPath}/{$mediaCategory}/{$showTitle}/Season_{$season}/{$rawTitle}";

        return $path; 
    }

    public function determineEpisodeFromFile($rawTitle)
    {
        $splitTitle = explode('-', $rawTitle);
        $episode = $splitTitle[0];

        return $episode; 
    }

    public function determineFileTypeFromFile($rawTitle)
    {
        $splitTitle = explode('.', $rawTitle);
        $fileType = $splitTitle[1];

        return $fileType; 
    }
}