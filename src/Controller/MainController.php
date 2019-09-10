<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        
        return $this->render('home/index.html.twig');


        /*return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MainController.php',
        ]);*/
    }

    /**
     * @Route("/storyboard/{name?}", name="storyboard")
     * @param Request $request
     * @return Response
     */
    public function storyboard(Request $request)
    {
       $name = $request->get('name');
        
        return $this->render('home/storyboard.html.twig', ['name' => $name]);

    }
}
