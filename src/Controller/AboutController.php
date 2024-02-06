<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class AboutController extends AbstractController
{
    //home.index c'est le nom de la route;
    #[Route('/about', name:'about.index')]
    public function index(): Response
    { 
        return $this->render('about.html.twig');
    }

    
}
// twig: moteur de template de symfony