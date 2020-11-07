<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Shows
 *
 * @ORM\Table(name="shows")
 * @ORM\Entity
 */
class Shows
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="filepath", type="string", length=500, nullable=false)
     */
    private $filepath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function setFilepath(string $filepath): self
    {
        $this->filepath = $filepath;

        return $this;
    }

    /**
     * This function retrieves show and episode from the OMDBapi
     * @return $movieDetails Returns API response data as an array  
     */
    public function getShowDetails(): ?array
    {
        $apiKey = $_ENV['API_KEY'];
        $client = HttpClient::create();

        $response = $client->request(
            'GET',
            "http://www.omdbapi.com/?apikey={$apiKey}&t={$this->title}"
        );

        if(array_key_exists('Error', $response->toArray())){
            $movieDetails = array('Plot' => "Unable to retrieve movie details from OMDBapi.", "Rated" => "No rating available", "Genre" => "Unavailable", "Year" => "Year unavailable");
        } else {
            $movieDetails = $response->toArray(); 
        }

        return $movieDetails;
    }
}
