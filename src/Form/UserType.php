<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'       => 'Nom',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'Ex: TCHANI'],
                'constraints' => [new NotBlank(['message' => 'Le nom est obligatoire.'])],
            ])
            ->add('prenom', TextType::class, [
                'label'       => 'Prénom',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'Ex: Wadou Djawada'],
                'constraints' => [new NotBlank(['message' => 'Le prénom est obligatoire.'])],
            ])
            ->add('email', EmailType::class, [
                'label'       => 'Adresse e-mail',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'utilisateur@exemple.com'],
                'constraints' => [
                    new NotBlank(['message' => 'L\'e-mail est obligatoire.']),
                    new Email(['message' => 'Adresse e-mail invalide.']),
                ],
            ])
            ->add('telephone', TelType::class, [
                'label'    => 'Téléphone',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => '+228 XX XX XX XX'],
            ])
            ->add('role', ChoiceType::class, [
                'label'   => 'Rôle',
                'attr'    => ['class' => 'form-select'],
                'choices' => [
                    'Étudiant'        => 'ROLE_ETUDIANT',
                    'Administrateur'  => 'ROLE_ADMIN',
                    'Établissement'   => 'ROLE_ETABLISSEMENT',
                ],
            ])
            ->add('actif', CheckboxType::class, [
                'label'    => 'Compte actif',
                'required' => false,
                'attr'     => ['class' => 'form-check-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
