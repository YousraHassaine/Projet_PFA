<?php

namespace App\Controller;
use App\Entity\Patient;
use App\Entity\TypeRdv;
use App\Repository\AppointmentRepository;
use DateTimeImmutable;
use App\Entity\Doctor;
use App\Entity\Speciality;
use App\Entity\Subscription;
use App\Entity\Appointment;
use App\Repository\SpecialityRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\DoctorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


class DoctorController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/doctor', name: 'app_doctor')]
    public function index(): Response
    {
        return $this->render('doctor/index.html.twig');
    }

    #[Route('/Doctor/login', name: 'loginDoctor')]
    public function login(): Response
    {
        return $this->render('doctor/login.html.twig');
    }
    #[Route('/Doctor/loginPost', name: 'loginDoctorPost',methods: "POST")]
    public function loginPost(SessionInterface $session, Request $request): Response
    {
        $login= $request->request->get("login");
        $password= $request->request->get("password");
        $entityManage=$this->entityManager;
        $doctor = $entityManage->getRepository(Doctor::class)->findOneBy(['Login' => $login, 'password' => $password]);

        if($doctor){
            $session->set('doctor', $doctor);
            return $this->redirectToRoute("rdvlist");
        }
        return $this->render('doctor/login.html.twig');
    }
    #[Route('/Doctor/register', name: 'registerDoctorForm')]
    public function registerForm(): Response
    {
        return $this->render('doctor/register.html.twig');
    }
    #[Route('/Doctor/Insrire', name: 'registerDoctor',methods: "POST")]
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
    #[Route('/doctor/detail/{id}', name: 'PrendreRdv',methods: "POST")]
    public function PrendreRdv(Request $request,int $id): Response
    {
        //dd($request);
        $Appointment = new Appointment();
      //  $createdAt = new DateTimeImmutable(($request->request->get("Date")));
        //!!!!!Pour le champs de CreatedAt par defaut va prendre la date actuel;
        $dateTime = new \DateTime();  // Obtenir la date et l'heure actuelles
        $dateTimeImmutable = DateTimeImmutable::createFromMutable($dateTime);  // Créer un objet DateTimeImmutable à partir de DateTime

        $Appointment->setCreatedAt($dateTimeImmutable);
        $Appointment->setHeureDebut(new DateTimeImmutable(($request->request->get("heureDebut"))));
        $Appointment->setHeureFin(new DateTimeImmutable(($request->request->get("heureFin"))));

        //Voous pouvez creer des attribut de type int pour le foreign key et affecter la valeur diirectement  ce sont des attribut chadeau
        $entityManage=$this->entityManager;
        //Type Rdv
        $TypeRdv=$entityManage->getRepository(TypeRdv::class)->find($request->request->get("typeRdv"));
        $Appointment->setTypeRdv($TypeRdv);

        //Doctor
        //Id est passé comment attribut sur url
        $Doctor=$entityManage->getRepository(Doctor::class)->find($id);
        $Appointment->setDoctor($Doctor);

        //Patient
        $Appointment->setPatientId(1);

        if($Appointment){
            $entityManage->persist($Appointment);
            $entityManage->flush();
            return $this->render('home.html.twig');
        }

        return $this->render('doctor/trouverDoctor.html.twig');
        
        

    }
    #[Route('/Doctor/fintrouverDoctord', name: 'trouveDoctor')]
    public function trouverDoctor(): Response
    {
        return $this->render('doctor/trouverDoctor.html.twig');
    }

    /**
     * action to get all specialities
     * 
     * @param SpecialityRepository $specialityRepository
     * 
     * @return Response
     */
    public function getDoctorsSpecialities(SpecialityRepository $specialityRepository): Response
    {
        $specialities = $specialityRepository->findAll();
        return $this->render('doctor/spec.html.twig',[
            "specialities" => $specialities
        ]);

    }
    public function getDoctorsSubscriptions(SubscriptionRepository $subscriptionRepository): Response
    {
            $subscriptions = $subscriptionRepository->findAll();
            return $this->render('doctor/subsc.html.twig',[
                "subscriptions" => $subscriptions
            ]);
    }
    #[Route('/doctor/detail/{id}', name: 'detail')]
    public function getDoctorDetail(SessionInterface $session , int $id, DoctorRepository $DoctorRepository): Response
    {
        $Details = $DoctorRepository->find($id);
        $session->set('Doctor', $Details);
        //dd($Details);
        return $this->render('doctor/detail.html.twig',[
            "Details" => $Details
        ]);
    }
    #[Route('/doctor/rdv', name: 'rdvlist')]
    public function rdvList(SessionInterface $session,AppointmentRepository $appointmentRepository):Response{
        if($session->has('doctor')){
            //////
            $doctor = $session->get('doctor');
            $appointments = $appointmentRepository->findAll();
            //dd($appointments);
            return $this->render("doctor/listeRdv.html.twig",[
                'appointments' => $appointments,
            ]);
        }
        return $this->redirectToRoute("loginDoctor");
    }
    #[Route('/doctor/update/{id}', name: 'updateAppointment')]
    public function updateAppointment(AppointmentRepository $appointmentRepository, $id):Response{
        //$appointment = $this->entityManager->getRepository(Appointment::class)->find($id);
        //dd($appointment);
        $appointment=$appointmentRepository->find($id);
        return $this->render("doctor/updateAppointment.html.twig",[
            'appointment' => $appointment,
        ]);
    }
    #[Route('/doctor/updatePost/{id}', name: 'DoctorRdvUpdate',methods: "POST")]
    public function PrendreRdvupdate(MailerInterface $mailer,$id,Request $request): Response
    {
        //dd($request);

            // dd($request);
            $entityManager = $this->entityManager;
            $Appointment = $entityManager->getRepository(Appointment::class)->find($id);
            $AncienneDate =$Appointment->getCreatedAt();
            if($Appointment){
                $createdAt = new \DateTimeImmutable(($request->request->get("Date")));
                $Appointment->setCreatedAt($createdAt);
                $entityManager->persist($Appointment);
                $entityManager->flush();
               // dd();
                //Todo Send Email
                $html = '<p>Ancienne date ' . $AncienneDate->format('Y-m-d H:i:s') . ' Nouvelle Date ' . $createdAt->format('Y-m-d H:i:s') . '</p>';

                $email = (new Email())
                    ->from('achraf.mimouni.test@gmail.com')
                    ->to($Appointment->getPatient()->getEmail())
                    ->subject('Changement de date rendez-vous')
                    ->html($html);

                $mailer->send($email);

                return $this->redirectToRoute('rdvlist');
            }
        return $this->redirectToRoute('loginDoctor');
    }


}
