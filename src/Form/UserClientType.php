<?php

namespace App\Form;

use App\Entity\Modele;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de Naissance',
                'widget' => 'single_text',
                'input' => 'datetime',
                'format' => 'yyyy-MM-dd',
            ])

            ->add('password', PasswordType::class, [
                'label' => 'Mot de Passe'
            ])
            ->add('roles', ChoiceType::class, [
                    'label' => 'Role',
                    'choices' => ["Administrateur" => "ROLE_ADMIN", "Utilisateur" => "ROLE_USER","Client"=>"ROLE_CLIENT"],
                    'expanded' => true,
                    'multiple' => true]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}