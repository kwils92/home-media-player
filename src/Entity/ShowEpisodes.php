<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * ShowEpisodes
 *
 * @ORM\Table(name="show_episodes", indexes={@ORM\Index(name="IDX_44B1BF3233FB6652", columns={"show_title_id"})})
 * @ORM\Entity
 */
class ShowEpisodes
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

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer", nullable=false)
     */
    private $rating;

    /**
     * @var int
     *
     * @ORM\Column(name="season", type="integer", nullable=false)
     */
    private $season;

    /**
     * @var int
     *
     * @ORM\Column(name="episode", type="integer", nullable=false)
     */
    private $episode;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=1, nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=25, nullable=false)
     */
    private $format;

    /**
     * @var \Shows
     *
     * @ORM\ManyToOne(targetEntity="Shows")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="show_title_id", referencedColumnName="id")
     * })
     */
    private $showTitle;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $episodePart;

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

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getSeason(): ?int
    {
        return $this->season;
    }

    public function setSeason(int $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getEpisode(): ?int
    {
        return $this->episode;
    }

    public function setEpisode(int $episode): self
    {
        $this->episode = $episode;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
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

    public function getShowTitle(): ?Shows
    {
        return $this->showTitle;
    }

    public function setShowTitle(?Shows $showTitle): self
    {
        $this->showTitle = $showTitle;

        return $this;
    }

    public function getEpisodePart(): ?string
    {
        return $this->episodePart;
    }

    public function setEpisodePart(?string $episodePart): self
    {
        $this->episodePart = $episodePart;

        return $this;
    }

    /**
     * This function retrieves movie details from the OMDBapi
     * @return $movieDetails Returns API response data as an array  
     */
    public function getEpisodeDetails(): ?array
    {
        $cache = new FileSystemAdapter(); 

        $cachedEpisodeDetails = $cache->get('hdc-' . $this->id, function () {
            $apiKey = $_ENV['API_KEY'];
            $client = HttpClient::create();
            $showTitle2 = $this->getShowTitle()->getTitle();
    
            $response = $client->request(
                "GET",
                "http://www.omdbapi.com/?apikey={$apiKey}&t={$showTitle2}&Season={$this->season}&Episode={$this->episode}"
            );
    
            if(array_key_exists('Error', $response->toArray())){
                $episodeDetails = array(
                    "Plot" => "Unable to retrieve movie details from OMDBapi.", 
                    "Rated" => "No rating available", 
                    "Genre" => "Unavailable", 
                    "Year" => "Year unavailable"
                );
            } else {
                $episodeDetails = $response->toArray(); 
            }

            return $episodeDetails; 
        });

        return $cachedEpisodeDetails;
    }
}
