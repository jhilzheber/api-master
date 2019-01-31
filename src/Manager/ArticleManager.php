<?php

namespace App\Manager;

use App\Repository\ArticleRepository;

class ArticleManager
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getArticleByName(string $name): ?array
    {
        return $this->articleRepository->findBy(['name' => $name], ['name' => 'ASC']);
    }
    public function getArticleByUserId($user)
    {
        return $this->articleRepository->findBy(['user' => $user]);
    }
}