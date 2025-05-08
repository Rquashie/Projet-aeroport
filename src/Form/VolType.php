<?php

namespace App\Form;

use App\Entity\Avion;
use App\Entity\User;
use App\Entity\Vol;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('villeDepart')
            ->add('villeArrive')
            ->add('dateDepart', null, [
                'widget' => 'single_text',
            ])
            ->add('heureDepart', null, [
                'widget' => 'single_text',
            ])
            ->add('prixBilletInitiale')
            ->add('refPilote', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'query_builder' => function (UserRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.roles LIKE :role')
                    ->setParameter('role', '%"ROLE_PILOTE"%');
                },

            ])
            ->add('refAvion', EntityType::class, [
                'class' => Avion::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
