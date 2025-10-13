<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $aslug = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $atitle = null;

    /**
     * @var Collection<int, Articlepic>
     */
    #[ORM\OneToMany(targetEntity: Articlepic::class, mappedBy: 'article', cascade: ['persist'], orphanRemoval: true)]
    private Collection $articlepics;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?User $user = null;

    public function __construct()
    {
        $this->articlepics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAslug(): ?string
    {
        return $this->aslug;
    }

    public function setAslug(?string $aslug): static
    {
        $this->aslug = $aslug;

        return $this;
    }

    public function getAtitle(): ?string
    {
        return $this->atitle;
    }

    public function setAtitle(?string $atitle): static
    {
        $this->atitle = $atitle;

        return $this;
    }

    /**
     * @return Collection<int, Articlepic>
     */
    public function getArticlepics(): Collection
    {
        return $this->articlepics;
    }

    public function addArticlepic(Articlepic $articlepic): static
    {
        if (!$this->articlepics->contains($articlepic)) {
            $this->articlepics->add($articlepic);
            $articlepic->setArticle($this);
        }

        return $this;
    }

    public function removeArticlepic(Articlepic $articlepic): static
    {
        if ($this->articlepics->removeElement($articlepic)) {
            // set the owning side to null (unless already changed)
            if ($articlepic->getArticle() === $this) {
                $articlepic->setArticle(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
