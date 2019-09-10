<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity= "App\Entity\Subject", mappedBy="category")
     */
    private $subject;



    public function __construct()
    {
        $this->subject = new ArrayCollection();
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
     * @return Collection|Subject[]
     */
    public function getSubject(): Collection
    {
        return $this->subject;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->subject->contains($subject)) {
            $this->subject[] = $subject;
            $subject->setCategory($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        if ($this->subject->contains($subject)) {
            $this->subject->removeElement($subject);
            // set the owning side to null (unless already changed)
            if ($subject->getCategory() === $this) {
                $subject->setCategory(null);
            }
        }

        return $this;
    }

    public function getCatCode(): ?string
    {
        return $this->catCode;
    }

    public function setCatCode(string $catCode): self
    {
        $this->catCode = $catCode;

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString method.
        return $this->name;
    }
}
