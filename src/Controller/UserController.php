<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Exception;
use FOS\RestBundle\Context\Context;

class UserController extends AbstractFOSRestController
{
    private $em;
    private $userRepo;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepo) {
        $this->em = $em;
        $this->userRepo = $userRepo;
    }

    /**
     * Get all users
     */
    public function getUsersAction()
    {
        return $this->view(
            $this->userRepo->findAll(),
            Response::HTTP_OK
        )->setContext(
            (new Context())->setGroups(['public'])
        );
    }
}
