<?php

namespace App\Entity;

use App\Repository\PostpicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostpicRepository::class)]
class Postpic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $postpic = null;

    #[ORM\ManyToOne(inversedBy: 'postpics')]
    private ?Post $post = null;

    #[ORM\Column(length: 255)]
    private ?string $alttxt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostpic(): ?string
    {
        return $this->postpic;
    }

    public function setPostpic(string $postpic): static
    {
        $this->postpic = $postpic;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

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
