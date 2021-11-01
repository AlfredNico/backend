<?php

namespace App\Controller;

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
}
