<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DoctorRepository;
use Doctrine\Persistence\ManagerRegistry;
class HomeController extends AbstractController
{

    
    //home.index c'est le nom de la route;
    #[Route('/', name:'home.index')]
    public function index(): Response
    { 
        return $this->render('home.html.twig');
    }

    #[Route('/Logout', name:'Logout')]
    public function Logout(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute("loginPatient");
    }

    #[Route('/doctors', name:'home.recherche')]
    public function recherche(Request $request, DoctorRepository $doctoor ): Response
    {
        $name = $request->request->get('name');// Récupérez le nom depuis la requête
      //  $specialty = $request->request->get('spécialité');// Récupérez la spécialité depuis la requête
        $city = $request->request->get('ville');// Récupérez la ville depuis la requête
        $doctors = $doctoor->rechercherParNomVilleSpecialite($name, $city);
       // dd($doctors);
       return $this->render('doctor/TrouverDoctor.html.twig',[
            'Doctors' => $doctors,
       ]);

    }




    /*#[Route('/Afficher', name: 'details_products')]
    public function Afficher(Request $request): Response
    {
        dd($request);

        return $this->render('details_products/index.html.twig');
    }*/

    
}
// twig: moteur de template de symfony