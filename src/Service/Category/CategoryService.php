<?php

namespace App\Service\Category;

use App\Entity\User;
use App\Entity\Category;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryService extends AbstractService
{
    protected EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getCategoriesByUser(User $user , array $options): array
    {
        $result = [];

        $limit = !empty($options['limit']) ? $options['limit'] : 5;
        $page = $options['page'];

        $query = $this->getManager()->getRepository(Category::class)
        ->createQueryBuilder('c')
        ->select('c')
        ->where('c.User = :user')
        ->setParameter('user', $user->getId())
        ->setMaxResults($limit)
        ->setFirstResult($page * $limit -$limit);
       
        $paginator = new Paginator($query);
        $categories = $paginator->getQuery()->getResult();
        $pages = ceil($paginator->count() / $limit);

        $result["categories"] = $categories;
        $result["pages"] = $pages;
        $result["page"] = $page;
        $result["limit"] = $limit;

        return $result;
    }
}