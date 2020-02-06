<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 25,
     *      minMessage = "Le nom de la vapote doit avoir minimum {{ limit }} caractères",
     *      maxMessage = "Le nom de la vapote doit avoir maximum {{ limit }} caractères"
     * )
     */
    private $name;


    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 25,
     *      minMessage = "Le modèle de la vapote doit avoir minimum {{ limit }} caractères",
     *      maxMessage = "Le modèle de la vapote doit avoir maximum {{ limit }} caractères"
     * )
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank
     * @Assert\Positive(message="{{ value }} n'est pas un chiffre")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank
     * @Assert\Positive(message="{{ value }} n'est pas un chiffre")
     */
    private $power;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank
     * @Assert\Positive(message="{{ value }} n'est pas un chiffre")
     */
    private $capacity;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank
     * @Assert\Positive(message="{{ value }} n'est pas un chiffre")
     */
    private $lenght;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank
     * @Assert\Positive(message="{{ value }} n'est pas un chiffre")
     */
    private $diameter;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank
     * @Assert\Positive(message="{{ value }} n'est pas un chiffre")
     */
    private $autonomy;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(
     *     minWidth = 300,
     *     maxWidth = 500,
     *     minHeight = 300,
     *     maxHeight = 500,
     *     groups = {"create"}
     * )
     */
    private $image;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Store", inversedBy="article")
     */
    private $store;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->store = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param mixed $store
     */
    public function setStore($store): void
    {
        $this->store = $store;
    }




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


    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPower(): ?string
    {
        return $this->power;
    }

    public function setPower(string $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getLenght(): ?string
    {
        return $this->lenght;
    }

    public function setLenght(string $lenght): self
    {
        $this->lenght = $lenght;

        return $this;
    }

    public function getDiameter(): ?string
    {
        return $this->diameter;
    }

    public function setDiameter(string $diameter): self
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function getAutonomy(): ?string
    {
        return $this->autonomy;
    }

    public function setAutonomy(string $autonomy): self
    {
        $this->autonomy = $autonomy;

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
            $comment->setArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection|Store[]
     */

    public function addStore(Store $store): self
    {
        if (!$this->store->contains($store)) {
            $this->store[] = $store;
        }

        return $this;
    }

    public function removeStore(Store $store): self
    {
        if ($this->store->contains($store)) {
            $this->store->removeElement($store);
        }

        return $this;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }






}
