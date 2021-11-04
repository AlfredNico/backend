<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AuthController extends AbstractFOSRestController
{
    private $JWTManager;
    private $userRepo;
    private $hasherPassword;

    public function __construct(JWTTokenManagerInterface $JWTManager, UserRepository $userRepo, UserPasswordHasherInterface $hasherPassword)
    {
        $this->JWTManager = $JWTManager;
        $this->userRepo = $userRepo;
        $this->hasherPassword = $hasherPassword;
    }

    /**
     * @Rest\RequestParam(name="username", description="username user", nullable=false)
     * @Rest\RequestParam(name="password", description="password user", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @return JsonResponse
     */
    public function getTokenUser(ParamFetcher $paramFetcher)
    {
        $username = ($paramFetcher->get('username'));
        $password = ($paramFetcher->get('password'));

        $user = $this->userRepo->findOneBy(['email' => $username]);

        if (is_null($user)) {
            return $this->view([
                'message' => 'username not fount'
            ], Response::HTTP_NOT_FOUND);
        }

        if (!$this->hasherPassword->isPasswordValid($user, $password)) {
            return $this->view([
                'message' => 'password not fount'
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->view([
            'username' => $user->getEmail(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
            'roles' => $user->getRoles(),
            'token' => $this->JWTManager->create($user),
        ], Response::HTTP_OK);
    }
}
