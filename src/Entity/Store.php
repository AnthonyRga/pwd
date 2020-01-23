<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 */
class Store
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 25,
     *      minMessage = "Le nom du magasin doit avoir minimum {{ limit }} caractères",
     *      maxMessage = "Le nom du magasin doit avoir maximum {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Choice({"Anvers", "Brabant flamand", "Brabant wallon", "Flandre", "Hainaut", "Liège", "Limbourg", "Luxembourg", "Namur"})
     * @Assert\NotBlank
     */
    private $province;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 25,
     *      minMessage = "La ville doit avoir minimum {{ limit }} caractères",
     *      maxMessage = "La ville doit avoir maximum {{ limit }} caractères"
     * )
     */
    private $ville;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 25,
     *      minMessage = "Le nom de la rue doit avoir minimum {{ limit }} caractères",
     *      maxMessage = "Le nom de la rue doit avoir maximum {{ limit }} caractères"
     * )
     */
    private $street;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 1,
     *      max = 6,
     *      minMessage = "Le numéro de la rue doit avoir minimum {{ limit }} caractères",
     *      maxMessage = "Le numéro de la rue doit avoir maximum {{ limit }} caractères",
     * )
     */
    private $number;

    /**
     * @return ArrayCollection
     */
    public function getArticle(): ArrayCollection
    {
        return $this->article;
    }

    /**
     * @param ArrayCollection $article
     */
    public function setArticle(ArrayCollection $article): void
    {
        $this->article = $article;
    }

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="store", cascade={"persist"})
     */

    private $article;

    public function __construct()
    {
        $this->article = new ArrayCollection();
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

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function addArticle(article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->addStore($this);
        }

        return $this;
    }

    public function removeArticle(article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
            $article->removeStore($this);
        }

        return $this;
    }




}
