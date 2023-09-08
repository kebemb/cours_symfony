<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bien', name: 'app_bien')]
class BienController extends AbstractController
{
    #[Route('/', name: '_liste')]
    public function index(BienRepository $bienRepository): Response
    {

        return $this->render('bien/index.html.twig', [
            'biens' => $bienRepository->findAll()
        ]);

    }

    #[Route('/tri/{slug}', name: '_tri')]
    public function tri(BienRepository $bienRepository, $slug): Response
    {

        if($slug=="prix_croissant") {
            $biens = $bienRepository->listBienSortedBy("prix", "ASC");
        }elseif($slug="nom_decroissant"){
            $biens = $bienRepository->listBienSortedBy("nom","DESC");
        }else{
            $biens = $bienRepository->findAll();
        }

        return $this->render('bien/index.html.twig', [
            'biens' => $biens
        ]);

    }

    #[Route('/{id}', name: '_voir', requirements: ['id' => '\d+'])]
    public function voir(Bien $bien): Response
    {

        return $this->render('bien/voir.html.twig', [
            'bien' => $bien
        ]);

    }
}
