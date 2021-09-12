<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\User;
use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Movie controller
 */
class MovieController extends AbstractFOSRestController
{

    private $movieRepo;
    private $userRepo;
    private $em;

    public function __construct(MovieRepository $movieRepo = null, EntityManagerInterface $em, UserRepository $userRepo) {
        $this->movieRepo = $movieRepo;
        $this->userRepo = $userRepo;
        $this->em = $em;
    }

    /**
     * get all movies
     * 
     * @return Movie[]
     */
    public function getMoviesAction()
    {
        return $this->view(
            $this->movieRepo->findAll(),
            Response::HTTP_OK
        );
    }

      /**
     * get all movies by users
     * 
     * @Rest\Get("users/{_user_id}/movies")
     * @return Movie[]
     */
    public function getMoviesByUser(User $user)
    {
        dd($this->movieRepo->findBy(['user' => $user->getUserID()]) );

        return $this->view(
            $this->movieRepo->findAll(),
            Response::HTTP_OK
        );
    }

    /**
     * create new movie
     * 
     * @Rest\RequestParam(name="user", description="user movie", nullable=false)
     * @Rest\FileParam(name="imageFile", description="background for movie", nullable=true, image=true)
     * @Rest\RequestParam(name="title", description="title movie", nullable=false)
     * @Rest\RequestParam(name="description", description="description movie", nullable=false)
     * @param ParamFetcher $paramFetcher
     */
    public function postMovieAction(ParamFetcher $paramFetcher)
    {
        $title = ($paramFetcher->get('title'));
        $user = trim($paramFetcher->get('user')) !== ""
            ? $this->userRepo->findOneBy(['_user_id' => $paramFetcher->get('user')])
            : null;
        $description = ($paramFetcher->get('description'));
        $file = ($paramFetcher->get('imageFile'));

        if (!empty(trim($title)) && !is_null($user)) {
            $movie = new Movie();
            // File System genereates
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );
                $movie->setMovieImg($fileName);
                $movie->setMovieImgURL("/uploads_image/" . $fileName);
            }
            $movie->setTitle($title);
            $movie->setDescription($description);
            $movie->setUser($user);

            $this->em->persist($movie);
            $this->em->flush();

            return $this->view(['message' => "Created succesfully."], Response::HTTP_CREATED);
        }
        return $this->view(['message' => "error created."], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * update a movie  by _movie_id
     * 
     * @Rest\RequestParam(name="title", description="title upadated movie", nullable=false)
     * @Rest\RequestParam(name="description", description="description updated movie", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @param Movie $movie
     * 
     * @Rest\Put("movie/{_movie_id}")
     */
    public function movie(ParamFetcher $paramFetcher, Movie $movie = null)
    {
        if (is_null($movie)) {
            return $this->view(['message' => "id movie undefined."], Response::HTTP_NOT_FOUND);
        }

        $title = ($paramFetcher->get('title'));
        $description = ($paramFetcher->get('description'));

        $movie->setTitle($title);
        $movie->setDescription($description);

        $this->em->persist($movie);
        $this->em->flush();
        return $this->view(['message' => "update movie succesfully"], Response::HTTP_OK); 
    }

      /**
     * get one moveie by _movie_id
     * 
     * @param movie $movie
     */
    public function getMovieAction(Movie $movie = null)
    {
        if (is_null($movie)) {
            return $this->view(['message' => "id movie undefined."], Response::HTTP_NOT_FOUND);
        }
        return $this->view($movie, Response::HTTP_BAD_REQUEST);
    }

    /**
     * delete movie  by _movie_id
     * 
     * @param movie $movie
     */
    public function deleteMovieAction(Movie $movie = null)
    {
        if (is_null($movie)) {
            return $this->view(['message' => "id movie undefined."], Response::HTTP_NOT_FOUND);
        }
        $this->em->remove($movie);
        $this->em->flush();

        return $this->view(['message' => "delete movie successfully."], Response::HTTP_NO_CONTENT);
    }

    /**
     * update image URL movie's image
     * 
     * @Rest\FileParam(name="imageFile", description="background for movie", nullable=false, image=true)
     * @param ParamFetcher $paramFetcher
     * @throws \Exception
     * @param Movie $movie
     */
    // * @throws \Exception
    public function imageMovieAction(ParamFetcher $paramFetcher, Movie $movie)
    {
        try {
            $fileSystem = new Filesystem();
            if (!is_null($movie->getMovieImg())) {
               $fileSystem->remove($this->getParameter('uploads_directory'). $movie->getMovieImg());
            }
            $file = ($paramFetcher->get('imageFile'));
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $fileName
                );
                $movie->setMovieImg($fileName);
                $movie->setMovieImgURL("/uploads_image/" . $fileName);

                $this->em->persist($movie);
                $this->em->flush();
            }
            return $this->view(['message' => "update image succesfully"], Response::HTTP_OK); 
        } catch (Exception $e) {
            return $this->view(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST); 
        }
    }

}
