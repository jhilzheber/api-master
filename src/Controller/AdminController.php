<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractFOSRestController
{
    /**
     * @Route("/admin", name="admin")
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     * @param $articles
     * @return \Symfony\Component\HttpFoundation\Response
     * @SWG\Response(
     *     response=200,
     *     description="Admin",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"user"}))
     *     )
     * )
     * @SWG\Tag(name="Admin")
     */

    public function index(UserRepository $userRepository, ArticleRepository $articleRepository)
    {
        $users = $userRepository->findAll();
        $articles = $articleRepository->findAll();
    }
}