<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 45)]
    private ?string $title = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $pslug = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?User $user = null;

    /**
     * @var Collection<int, Postpic>
     */
    #[ORM\OneToMany(targetEntity: Postpic::class, mappedBy: 'post')]
    private Collection $postpics;

    /**
     * @var Collection<int, Postcomment>
     */
    #[ORM\OneToMany(targetEntity: Postcomment::class, mappedBy: 'post')]
    private Collection $postcomments;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts')]
    private Collection $post_has_categories;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'likes')]
    private Collection $likes;

    public function __construct()
    {
        $this->postpics = new ArrayCollection();
        $this->postcomments = new ArrayCollection();
        $this->post_has_categories = new ArrayCollection();
        $this->likes = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPslug(): ?string
    {
        return $this->pslug;
    }

    public function setPslug(?string $pslug): static
    {
        $this->pslug = $pslug;

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

    /**
     * @return Collection<int, Postpic>
     */
    public function getPostpics(): Collection
    {
        return $this->postpics;
    }

    public function addPostpic(Postpic $postpic): static
    {
        if (!$this->postpics->contains($postpic)) {
            $this->postpics->add($postpic);
            $postpic->setPost($this);
        }

        return $this;
    }

    public function removePostpic(Postpic $postpic): static
    {
        if ($this->postpics->removeElement($postpic)) {
            // set the owning side to null (unless already changed)
            if ($postpic->getPost() === $this) {
                $postpic->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Postcomment>
     */
    public function getPostcomments(): Collection
    {
        return $this->postcomments;
    }

    public function addPostcomment(Postcomment $postcomment): static
    {
        if (!$this->postcomments->contains($postcomment)) {
            $this->postcomments->add($postcomment);
            $postcomment->setPost($this);
        }

        return $this;
    }

    public function removePostcomment(Postcomment $postcomment): static
    {
        if ($this->postcomments->removeElement($postcomment)) {
            // set the owning side to null (unless already changed)
            if ($postcomment->getPost() === $this) {
                $postcomment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getPostHasCategories(): Collection
    {
        return $this->post_has_categories;
    }

    public function addPostHasCategory(Category $postHasCategory): static
    {
        if (!$this->post_has_categories->contains($postHasCategory)) {
            $this->post_has_categories->add($postHasCategory);
        }

        return $this;
    }

    public function removePostHasCategory(Category $postHasCategory): static
    {
        $this->post_has_categories->removeElement($postHasCategory);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
        }

        return $this;
    }

    public function removeLike(User $like): static
    {
        $this->likes->removeElement($like);

        return $this;
    }
}
