<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\Table(name="articles")
 * @UniqueEntity("title", message="Надоел постить одну и ту же новость")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Заголовок обязателен для заполнения")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Заголовок должен быть больше 5-ти букавак",
     *      maxMessage = "Заголовок должен быть не больше 255-ти букавак"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublish;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", mappedBy="article")
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private $tag;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->tag = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getIsPublish()
    {
        return $this->isPublish;
    }

    /**
     * @param $isPublish
     * @return $this
     */
    public function setIsPublish($isPublish)
    {
        $this->isPublish = $isPublish;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return ArrayCollection|Tag[]
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param Tag $tag
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        if ($this->tag->contains($tag)) {
            return $this;
        }

        $this->tag[] = $tag;
        $tag->addArticle($this);

        return $this;
    }

    /**
     * @param Tag $tag
     * @return $this
     */
    public function removeTag(Tag $tag)
    {
        $this->tag->removeElement($tag);

        return $this;
    }
}
