<?php

namespace App\Controller;

use App\Repository\TypeRdvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeRDVController extends AbstractController
{
    #[Route('/type/r/d/v', name: 'app_type_r_d_v')]
    public function PrendreRdvType(TypeRdvRepository $typeRdvRepository): Response
    {
        $typesRdv=$typeRdvRepository->findAll();

        return $this->render('type_rdv/index.html.twig', [
            'typeRdvs' => $typesRdv,
        ]);
    }
}
