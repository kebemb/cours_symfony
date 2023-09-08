<?php

namespace App\Form;

use App\Entity\BienUser;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BienUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('dateAcces', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('user', EntityType::class,[
                'class' => User::class,
                'choice_label' => 'nom',
                'label' => 'Quel utilisateur ?'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BienUser::class,
        ]);
    }
}
