<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class ArticleController extends AbstractFOSRestController
{
    private $articleRepository;
    private $em;

    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $this->articleRepository = $articleRepository;
        $this->em = $entityManager;
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return details of an article",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Article::class, groups={"articles"}))
     *     )
     * )
     * @SWG\Tag(name="Return details of an article")
     * @Rest\Get("/api/articles/{id}")
     * @param Article $article
     * @return \FOS\RestBundle\View\View
     */
    public function getApiArticle(Article $article)
    {
        return $this->view( $article );
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return all of articles",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Article::class, groups={"articles"}))
     *     )
     * )
     * @SWG\Tag(name="Return all of articles")
     * @Rest\Get("/api/articles")
     * @Rest\View(serializerGroups={"articles"})
     */
    public function getApiArticles()
    {
        $articles = $this->articleRepository->findAll();
        return $this->view( $articles );
        // "get_articles
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Update of an article",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Article::class, groups={"articles"}))
     *     )
     * )
     * @SWG\Tag(name="Update of an article")
     * @Rest\Patch("/api/articles/{id}")
     * @param Article $article
     * @param Request $request
     * @return string
     */
    public function patchApiArticle(Article $article, Request $request)
    {
        $name = $request->get( 'name' );
        $description = $request->get( 'description' );
        $createdAt = $request->get( 'createdAt' );
        $user = $request->get( 'user' );

        if ($name !== null) {
            $article->setName( $name );
        }
        if ($description !== null) {
            $article->setDescription( $description );
        }
        if ($createdAt !== null) {
            $article->setcreatedAt( $createdAt );
        }
        if ($user !== null) {
            $article->setUser( $user );
        }

        $this->em->persist( $user );
        $this->em->flush();
        return $this->json( $user );
    }


    /**
     * @SWG\Response(
     *     response=200,
     *     description="A new article",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Article::class, groups={"articles"}))
     *     )
     * )
     * @SWG\Tag(name="A new article")
     * @Rest\Post("/api/articles")
     * @Rest\View(serializerGroups={"articles"})
     * @ParamConverter("article", converter="fos_rest.request_body")
     * @return \FOS\RestBundle\View\View
     */
    public function postApiArticle(Article $article)
    {
        $this->em->persist( $article );
        $this->em->flush();
        return $this->view( $article );
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Deleting of an article",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Article::class, groups={"articles"}))
     *     )
     * )
     * @SWG\Tag(name="Deleting of an article")
     * @Rest\Delete("/api/articles/{id}")
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function DeleteApiArticle(Article $article)
    {
        $this->em->remove( $article );
        $this->em->flush();
        return $this->json( 'OK' );
    }
}