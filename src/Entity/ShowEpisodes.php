<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\String_;

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
}
