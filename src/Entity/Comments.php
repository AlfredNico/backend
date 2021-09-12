<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Comments
{
    use Timestamps; //include timestamps

    /**
     * @var uuid
     * 
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="uuid", name="_comment_id", unique=true)
     */
    private $_comment_id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    public function __construct() {
        $this->_comment_id = Uuid::v4();
    }

    public function getCommentID(): ?Uuid
    {
        return $this->_comment_id;
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
}
