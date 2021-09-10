<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

class UserController extends AbstractFOSRestController
{
    private $em;
    private $hasherPassword;
    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasherPassword) {
        $this->em = $em;
        $this->hasherPassword = $hasherPassword;
    }


    /**
     * create new USER
     * 
     * @Rest\RequestParam(name="username", description="username user value", nullable=false)
     * @Rest\RequestParam(name="password", description="password user value", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @Rest\Post("registration")
     */
    public function postUser(ParamFetcher $paramFetcher)
    {
        $user = new User();
        $user->setEmail($paramFetcher->get('username'));
        $user ->setPassword(
            $this->hasherPassword->hashPassword($user, $paramFetcher->get('password'))
        );

        $this->em->persist($user);
        $this->em->flush();
        return $this->view(['message' => "user created successfully."], Response::HTTP_OK);
    }
}
