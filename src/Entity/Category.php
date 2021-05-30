<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="belong")
     */
    private $troc;

    public function __construct()
    {
        $this->troc = new ArrayCollection();
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

    /**
     * @return Collection|Product[]
     */
    public function getTroc(): Collection
    {
        return $this->troc;
    }

    public function addTroc(Product $troc): self
    {
        if (!$this->troc->contains($troc)) {
            $this->troc[] = $troc;
            $troc->setBelong($this);
        }

        return $this;
    }

    public function removeTroc(Product $troc): self
    {
        if ($this->troc->removeElement($troc)) {
            // set the owning side to null (unless already changed)
            if ($troc->getBelong() === $this) {
                $troc->setBelong(null);
            }
        }

        return $this;
    }
}
