<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\BienUser;
use App\Form\BienType;
use App\Repository\BienRepository;
use App\Service\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/bien', name: 'app_admin_bien')]
class AdminBienController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function lister(BienRepository $bienRepository): Response
    {

        return $this->render('admin/admin_bien/index.html.twig',[
            'biens' => $bienRepository->findBy([
                'gestionnaire' => $this->getUser()
            ])
        ]);

    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           BienRepository $bienRepository,
                           UploadService $uploadService,
                           int $id = null): Response
    {
        if($id == null) {
            $bien = new Bien();
            $bienUser = new BienUser();
            $bien->addBienUser($bienUser);
        }else{
            $bien = $bienRepository->find($id);

            // je contrôle que le bien appartient au bon gestionnaire
            if($bien->getGestionnaire() !== $this->getUser()){

                $this->addFlash(
                    'danger',
                    'Non petit coquin, je sais où tu habites'
                );

                return $this->redirectToRoute('app_admin_bien_lister');

            }

        }

        $form = $this->createForm(BienType::class,$bien);

        $form->handleRequest($request);

        // si le form est soumis et est valide
        if($form->isSubmitted() && $form->isValid()){

            $bien->setGestionnaire($this->getUser());

            // JE GERE L'UPLOAD ICI
            if ($form->get('photo')->getData()) {
                $newFilename = $uploadService->upload($form->get('photo')->getData(), $this->getParameter('biens_directory'));
                $bien->setPhotoPrincipale($newFilename);
            }

            // traitement des données
            $entityManager->persist($bien);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le bien a été ' . ($id == null ? 'ajouté' : 'modifié') . ' !'
            );

            return $this->redirectToRoute('app_admin_bien_lister');

        }

        return $this->render('admin/admin_bien/editer_bien.html.twig',[
            'form' => $form,
            'bien' => $bien
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function supprimer(EntityManagerInterface $entityManager,
                              BienRepository $bienRepository,
                              int $id) : Response
    {

        $bien = $bienRepository->find($id);
        $entityManager->remove($bien);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Le bien a été supprimé !'
        );

        return $this->redirectToRoute('app_admin_bien_lister');
    }
}
