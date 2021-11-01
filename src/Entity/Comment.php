<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\Table(name="comments")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="uuid", name="_comment_id", unique=true)
     */
    private Uuid $_comment_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comment")
     * @ORM\JoinColumn(nullable=false, name="article_id", referencedColumnName="_article_id")
     */
    private $article;


    public function getCommentID(): ?Uuid
    {
        return $this->_comment_id = Uuid::v4();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
