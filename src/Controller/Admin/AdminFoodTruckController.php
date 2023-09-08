<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\FoodTruck;
use App\Form\BienType;
use App\Form\FoodTruckType;
use App\Repository\BienRepository;
use App\Repository\FoodTruckRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/foodtruck', name: 'app_admin_foodtruck')]
class AdminFoodTruckController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function lister(FoodTruckRepository $foodTruckRepository): Response
    {

        return $this->render('admin/admin_foodtruck/index.html.twig',[
            'foodtrucks' => $foodTruckRepository->findAll()
        ]);

    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           FoodTruckRepository $foodTruckRepository,
                           int $id = null): Response
    {
        if($id == null) {
            $foodTruck = new FoodTruck();
        }else{
            $foodTruck = $foodTruckRepository->find($id);
        }

        $form = $this->createForm(FoodTruckType::class,$foodTruck);

        $form->handleRequest($request);

        // si le form est soumis et est valide
        if($form->isSubmitted() && $form->isValid()){

            // traitement des données
            $entityManager->persist($foodTruck);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le food truck a été ' . ($id == null ? 'ajouté' : 'modifié') . ' !'
            );

            return $this->redirectToRoute('app_admin_foodtruck_lister');

        }


        return $this->render('admin/admin_foodtruck/editer_foodtruck.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function supprimer(EntityManagerInterface $entityManager,
                              FoodTruck $foodTruck) : Response
    {

        $entityManager->remove($foodTruck);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Le food truck a été supprimé !'
        );

        return $this->redirectToRoute('app_admin_foodtruck_lister');
    }
}
