<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DoctorRepository;
use Doctrine\Persistence\ManagerRegistry;

class register2Controller extends AbstractController
{
    
    //home.index c'est le nom de la route;
    #[Route('/register2', name:'register2')]
    public function index(): Response
    { 
        return $this->render('doctor/register2.html.twig');
    }
}