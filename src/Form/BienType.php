<?php

namespace App\Form;

use App\Entity\Bien;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('photo', FileType::class, [
                'label' => 'Photo du bien',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un PNG ou un JPG',
                    ])
                ],
            ])
            ->add('dateDispo', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('avecJardin')
            ->add('ville', EntityType::class,[
                'class' => Ville::class,
                'choice_label' => 'nomCodePostal'
            ])

            ->add('bienUsers', CollectionType::class,[
                'entry_type' => BienUserType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
        ]);
    }
}
