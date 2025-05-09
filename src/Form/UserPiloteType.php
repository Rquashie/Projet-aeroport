<?php
// src/Form/UserPiloteType.php

namespace App\Form;

use App\Entity\Modele;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use function Sodium\add;
use Symfony\Component\Validator\Constraints as Assert;

class UserPiloteType extends AbstractType
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
            ->add('refModele', EntityType::class, [
                'label' => 'Référence Modèle',
                'class' => Modele::class,
                'choice_label' => 'id',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de Passe',
                'constraints' => [
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit comporter au moins {{ limit }} caractères.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[A-Z]/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[a-z]/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre minuscule.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/\d/',
                        'message' => 'Le mot de passe doit contenir au moins un chiffre.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[\W_]/',
                        'message' => 'Le mot de passe doit contenir au moins un caractère spécial.',
                    ]),
                ],
            ]);

            }

    public function configureOptions(OptionsResolver $resolver): void
    {

        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
