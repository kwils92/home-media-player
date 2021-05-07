<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpClient\HttpClient;

/**
 * @ORM\Entity(repositoryClass=MoviesRepository::class)
 */
class Movies
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $filepath;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $category = [];

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $format;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sortingField;

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

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCategory(): ?array
    {
        return json_decode($this->category);
    }

    public function setCategory(?array $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getSortingField(): ?string
    {
        return $this->sortingField; 
    }

    public function setSortingField($sortingField): self
    {
        $this->sortingField = $sortingField; 

        return $this; 
    }

    /**
     * This function retrieves movie details from the OMDBapi
     * @return $movieDetails Returns API response data as an array  
     */
    public function getMovieDetails(): ?array
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
