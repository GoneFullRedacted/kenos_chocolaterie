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

    #[ORM\Column(length: 45)]
    private ?string $pic = null;

    #[ORM\ManyToOne(inversedBy: 'articlepics')]
    private ?Article $article = null;

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
}
