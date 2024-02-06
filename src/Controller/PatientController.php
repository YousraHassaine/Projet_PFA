<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\Speciality;
use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/Patient/login', name: 'loginPatient')]
    public function login(): Response
    {
        return $this->render('Patient/login.html.twig');
    }
    #[Route('/Patient/inscrire', name: 'loginPatientPost',methods: "POST")]
    public function loginPost(Request $request, SessionInterface $session): Response
    {
        $login= $request->request->get("login");
        $password= $request->request->get("password");
        $entityManage=$this->entityManager;
        $patient = $entityManage->getRepository(Patient::class)->findOneBy(['Login' => $login, 'password' => $password]);
        //dd($patient);*
       // dd($patient);
        if($patient!=null ){
            $session->set('patient_id', $patient);
            if($session->get('Doctor')==null){
                return $this->redirectToRoute('rdv_index');
            }
            else{
                return  $this->redirectToRoute('rdvCreate');
            }

            //dd($session->get('patient_id'));

        }
        return $this->render('Patient/login.html.twig');
    }
    #[Route('/Patient/register', name: 'registerPatientForm')]
    public function registerForm(): Response
    {
        return $this->render('doctor/register.html.twig');
    }
    #[Route('/Patient/Insrire', name: 'registerPatient',methods: "POST")]
    public function register(Request $request): Response
    {
        //dd($request);
        $doctor=new Doctor();
        $doctor->setNom($request->request->get("nom"));
        $doctor->setCIN("FRRRRR");
        $doctor->setAdresse("RRRR");
        $doctor->setVille("oujda");
        $doctor->setPrenom($request->request->get("prenom"));
        $doctor->setTel($request->request->get("telephone"));
        $doctor->setEmail($request->request->get("email"));

        $doctor->setSexe($request->request->get("sexe"));
        $doctor->setLogin($request->request->get("Login"));
        $doctor->setPassword($request->request->get("password"));
        $doctor->setPhotp("user.jpg");
        $doctor->setDisponibilite(false);

        $SubscriptionId=$request->request->get("subscription");

        $SpecialtyId=$request->request->get("speciality");
        $entityManage=$this->entityManager;
        $Subscription=$entityManage->getRepository(Subscription::class)->find( $SubscriptionId);
        $doctor->setSubscription($Subscription);
        $speciality=$entityManage->getRepository(Speciality::class)->find($SpecialtyId);
        $doctor->setSpecialty($speciality);
        $entityManage->persist($doctor);
        $entityManage->flush();
        return $this->render('doctor/register.html.twig');
    }

}
