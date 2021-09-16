<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 * @UniqueEntity(
 *  fields={"title"},
 *  message= "La catégorie {{ value }} existe déjà."
 * )
 */
class Categorie {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * Id de la catégorie auto-increment Attention on n'y touche pas.
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=65)
     * @Assert\Length(
     *  min=3,
     *  max=65,
     *  minMessage="Le nombre de caractère demandé doit être supérieur à {{ limit }} caractères, vous avez saisi {{ value  }}.",
     *  maxMessage="Le nombre de caractère demandé doit être inférieur à {{ limit }} caractères, vous avez saisi {{ value }}."
     * )
     * @Assert\Regex(
     *  pattern="/^[a-zA-Z0-9-_\ ']+$/",
     *  message="Seuls les lettres, les chiffres et les caractères <<' -_>> sont autorisés"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="category")
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setCategory($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getCategory() === $this) {
                $post->setCategory(null);
            }
        }

        return $this;
    }
}