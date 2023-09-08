<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\Ville;
use App\Form\BienType;
use App\Form\VilleType;
use App\Repository\BienRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ville', name: 'app_admin_ville')]
class AdminVilleController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function lister(VilleRepository $villeRepository): Response
    {

        return $this->render('admin/admin_ville/index.html.twig',[
            'villes' => $villeRepository->findAll()
        ]);

    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           VilleRepository $villeRepository,
                           int $id = null): Response
    {
        if($id == null) {
            $ville = new Ville();
        }else{
            $ville = $villeRepository->find($id);
        }

        $form = $this->createForm(VilleType::class,$ville);

        $form->handleRequest($request);

        // si le form est soumis et est valide
        if($form->isSubmitted() && $form->isValid()){

            // traitement des données
            $entityManager->persist($ville);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'La ville a été ' . ($id == null ? 'ajoutée' : 'modifiée') . ' !'
            );

            return $this->redirectToRoute('app_admin_ville_lister');

        }


        return $this->render('admin/admin_ville/editer_ville.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function supprimer(EntityManagerInterface $entityManager,
                              Ville $ville) : Response
    {
        $entityManager->remove($ville);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'La ville a été supprimée !'
        );

        return $this->redirectToRoute('app_admin_ville_lister');
    }
}
