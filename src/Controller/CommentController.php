<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class CommentController extends AbstractFOSRestController
{
    private $commentRepo;
    private $em;
    public function __construct(CommentRepository $commentRepo, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->commentRepo = $commentRepo;
    }
    /**
     * get all comments
     * 
     * @param ParamFetcher $paramFetcher
     * @param string $article
     */
    public function getArticleCommentsAction(ParamFetcher $paramFetcher, string $article)
    {
        if (!is_null($article)) {
            return $this->view(
                $this->commentRepo->findBy(
                    [
                        'article' => $article,
                        'createdAt' => 'DESC'
                    ]
                ),
                Response::HTTP_OK
            );
        }
        return $this->view(
            ['message' => 'no movie found'],
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * post comment
     * 
     * @Rest\RequestParam(name="description", description="description commnent", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @param Article $article
     */
    public function postCommentAction(ParamFetcher $paramFetcher, Article $article)
    {
        $description = ($paramFetcher->get('description'));

        if (!empty(trim($description)) && !is_null($description)) {
            $comment = new Comment();
            $comment->setDescription($description);
            $comment->setArticle($article);

            $this->em->persist($comment);
            $this->em->flush();
            return $this->view([$comment], Response::HTTP_CREATED);
        }
    }

    /**
     * put comment
     */
    public function putCommentAction()
    {
    }
}
