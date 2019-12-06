<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param PropertyRepository
     * @return response
     */
    public function index(PropertyRepository $property): Response
    {

        $properties = $property->findLatest();

        return $this->render('home/index.html.twig', [
            'properties' => $properties
        ]);
    }
}
