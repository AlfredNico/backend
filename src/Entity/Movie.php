<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="movie")
 */
class Movie
{

    use Timestamps; //include timestamps

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="_movie_id", unique=true)
     */
    private int $_movie_id = 0;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=25, name="title", options={"default"="undefined"})
     * @Assert\NotBlank(message="movie title should be blank.")
     */
    private string $title;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true, name="description")
     */
    private string $description;

     /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true, name="movie_img", options={"default"="movie_img.jpeg"})
     */
    private string $movieImg = "movie_img.jpeg";

     /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true, name="movie_img_url", options={"default"="movie_img.jpeg"})
     */
    private string $movieImgURL = "movie_img.jpeg";


    public function getMovieID(): ?int
    {
        return $this->_movie_id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMovieImg(): ?string
    {
        return $this->movieImg;
    }

    public function setMovieImg(?string $movieImg): self
    {
        $this->movieImg = $movieImg;

        return $this;
    }

    public function getMovieImgURL(): ?string
    {
        return $this->movieImgURL;
    }

    public function setMovieImgURL(?string $movieImgURL): self
    {
        $this->movieImgURL = $movieImgURL;

        return $this;
    }

    
}
