<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class ContactController extends AbstractController
{
    //home.index c'est le nom de la route;
    #[Route('/contact', name:'contact.index')]
    public function index(): Response
    { 
        return $this->render('contact.html.twig');
    }

    
}