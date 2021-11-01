<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends AbstractFOSRestController
{
    // private $commentRepo;
    // public function __construct(CommentRepository $commentRepo) {
    //     $this->commentRepo = $commentRepo;
    // }
    // /**
    //  * get all comments
    //  * 
    //  * @RequestParam(name="description", description="comment description", nullable=false)
    //  * @RequestParam(name="description", description="comment description", nullable=false)
    //  * @param ParamFetcher $paramFetcher
    //  * @param Movie $movie
    //  */
    // public function getMoviesCommentsAction(ParamFetcher $paramFetcher, Movie $movie)
    // {
    //     if (!is_null($movie)) {
    //         return $this->view(
    //             $this->commentRepo->findAll(),
    //             Response::HTTP_OK
    //         );
    //     }
    //     return $this->view(
    //         ['message' => 'no movie found'],
    //         Response::HTTP_NOT_FOUND
    //     );
    // }

    // /**
    //  * post comment
    //  */
    // public function postCommentAction()
    // {

    // }

    //  /**
    //  * put comment
    //  */
    // public function putCommentAction()
    // {

    // }
}
