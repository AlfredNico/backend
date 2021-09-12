<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="movies")
 */
class Movie
{

    use Timestamps; //include timestamps

    /**
     * @var uuid
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="uuid", name="_movie_id", unique=true)
     */
    private Uuid $_movie_id;
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

    // ================================= RELATION CLASS USER =========================
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="movies", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false, name="user_id", referencedColumnName="_user_id")
     */
    private User $user;

    /**
     * @var Collection<Uuid, Comment>
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="movie", orphanRemoval=true)
     */
    private Collection $comments;


    public function __construct() {
        $this->_movie_id = Uuid::v4();
        $this->comments = new ArrayCollection();
    }

    public function getMovieID(): ?Uuid
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

    // ================================= RELATION CLASS USER getter & setter =========================
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setMovie($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMovie() === $this) {
                $comment->setMovie(null);
            }
        }

        return $this;
    }
}
