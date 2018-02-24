<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return mixed|Article[]
     */
    public function findAllArticle()
    {
        return $this->createQueryBuilder('article')
            ->andWhere('article.isPublish=:publish and article.createdAt <= :date')
            ->setParameter('publish', true)
            ->setParameter('date', new \DateTime())
            ->orderBy('article.updatedAt')
            ->getQuery()
            ->getResult()
        ;
    }
}
