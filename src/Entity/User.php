<?php

namespace App\Entity;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property string api_key
 * @UniqueEntity("email")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */

class User implements UserInterface
{
    /**
     * @Groups("user")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @SWG\Property(description="The unique identifier of the user.")
     */
    private $id;

    /**
     * @SWG\Property(description="The firstname of the user.")
     * @Groups("user")
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @SWG\Property(description="The lastname of the user.")
     * @Groups("user")
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @SWG\Property(description="The email of the user.")
     * @Groups("user")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @SWG\Property(description="The date of birthday of the user.")
     * @Groups("user")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @SWG\Property(description="The role of the user.")
     * @Groups("user")
     * @ORM\Column(type="simple_array")
     */
    private $roles = [];

    /**
     * @SWG\Property(description="The api_key of the user.")
     * @Groups("user")
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     */
    private $apiKey;
    /**
     * @SWG\Property(description="The list of articles of the user.")
     * @Groups({"articles", "user"})
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="user")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->api_key = uniqid();
        $this->roles = array('ROLE_USER');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(?string $apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    /**
     * @return Collection|article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }
}
