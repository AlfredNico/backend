<?php 
namespace App\Entity;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;


trait Timestamps{

    /**
     * @ORM\Column(name="created_at", nullable=false, type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", nullable=false, type="datetime")
     */
    private $updatedAt;

    public function setCreatedAt(?DateTimeInterface $timestamp):self
    {
        $this->createdAt = $timestamp;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(?DateTimeInterface $timestamp):self
    {
        $this->updatedAt = $timestamp;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtAutomatically()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime());
        }
        $this->setUpdatedAt(new \DateTime());
    }

     /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtAutomatically()
    {
        $this->setUpdatedAt(new \DateTime());
    }

}