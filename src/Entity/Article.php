<?php

namespace App\Entity;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @Groups({"user", "articles"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @SWG\Property(description="The unique identifier of the article.")
     */
    private $id;

    /**
     * @SWG\Property(description="The name of the article.")
     * @Groups({"user", "articles"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @SWG\Property(description="The description of the article.")
     * @Groups({"user", "articles"})
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @SWG\Property(description="The date of creation of the article.")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @SWG\Property(description="The author of the article.")
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
