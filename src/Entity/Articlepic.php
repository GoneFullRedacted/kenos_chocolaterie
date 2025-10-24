<?php

namespace App\Entity;

use App\Repository\ArticlepicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlepicRepository::class)]
class Articlepic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pic = null;

    #[ORM\ManyToOne(inversedBy: 'articlepics')]
    private ?Article $article = null;

    #[ORM\Column(length: 255)]
    private ?string $alttxt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPic(): ?string
    {
        return $this->pic;
    }

    public function setPic(string $pic): static
    {
        $this->pic = $pic;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getAlttxt(): ?string
    {
        return $this->alttxt;
    }

    public function setAlttxt(string $alttxt): static
    {
        $this->alttxt = $alttxt;

        return $this;
    }
}
