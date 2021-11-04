<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationController extends AbstractFOSRestController
{
    private $userRepo;
    private $hasherPassword;
    private $em;

    public function __construct(UserRepository $userRepo, UserPasswordHasherInterface $hasherPassword, EntityManagerInterface $em)
    {
        $this->userRepo = $userRepo;
        $this->hasherPassword = $hasherPassword;
        $this->em = $em;
    }
    /**
     * Registration new user
     */
    public function registration(Request $request)
    {

        // dd(bin2hex(random_bytes(20)));
        $email = $request->get('email');
        $password = $request->get('password');
        $roles = !empty($request->get('roles'))
            ? $request->get('roles')
            : ['USER_ROLE'];

        $isUser = $this->userRepo->findOneBy(['email' => $email]);

        if (!is_null($isUser)) {
            return $this->view(['message' => 'email already excist'], Response::HTTP_CONFLICT);
        }

        try {
            $user =  new User();
            $user->setEmail($email);
            $user->setPassword(
                $this->hasherPassword->hashPassword($user, $password)
            );
            $user->setRoles($roles);

            $this->em->persist($user);
            $this->em->flush();
            return $this->view(['message' => "user created successfully."], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->view(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // /**
    //  * @param UserInterface $user
    //  * @param JWTTokenManagerInterface $JWTManager
    //  * @return JsonResponse
    //  *  @Route("/api/login_check", name="api_login_check")
    //  * @Method({"POST"})
    //  */
    // public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    // {
    //     dd($user);

    //     return $this->view([
    //         'token' => $JWTManager->create($user)
    //     ], Response::HTTP_OK);
    // }
}
