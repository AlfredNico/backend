<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Routing\RouterInterface;

class CircularReferenceHandler
{

    private $router;

    public function __construct(RouterInterface $router = null)
    {
        $this->router = $router;
    }

    public function __invoke($object)
    {

        switch ($object) {
            case $object instanceof Article:
                // return $this->router->generate('app_user_getuser', ['_user_id' => $object->getUser()->getUserID()]);
                return $object->getId();

            case $object instanceof User:
                return $object->getUserId();

            case $object instanceof Comment:
                return $object->getCommentID();
        }
    }
}
