<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ArticleController extends AbstractFOSRestController
{
    private $articleRepo;
    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function getArticlesAction()
    {
        return $this->view(
            $this->articleRepo->findAll(),
            Response::HTTP_OK
        );
    }

    /**
     * get one moveie by id
     * 
     * @param Article $article
     */
    public function getArticleAction(Article $article = null)
    {
        if (is_null($article)) {
            return $this->view(['message' => "id movie undefined."], Response::HTTP_NOT_FOUND);
        }
        return $this->view($article, Response::HTTP_OK);
    }
}
