<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tags")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="tag")
     */
    private $article;


    public function __construct()
    {
        $this->article = new ArrayCollection();
    }


    /**
     * @return ArrayCollection|Article[]
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param Article $article
     * @return $this
     */
    public function addArticle(Article $article)
    {
        if($this->article->contains($article)){
            return $this;
        }

        $this->article[] = $article;
        $article->addTag($this);
    }

    /**
     * @param Article $article
     */
    public function removeArticle(Article $article)
    {
        $this->article->removeElement($article);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }
}
