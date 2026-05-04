<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit'];

        $builder
            ->add('nom', TextType::class, [
                'label'       => 'Nom',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'Ex: TCHANI'],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est obligatoire.']),
                    new Length(['min' => 2, 'max' => 100,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.']),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label'       => 'Prénom',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'Ex: Wadou'],
                'constraints' => [
                    new NotBlank(['message' => 'Le prénom est obligatoire.']),
                    new Length(['min' => 2, 'max' => 100,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.']),
                ],
            ])
            ->add('email', EmailType::class, [
                'label'       => 'Adresse e-mail',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'utilisateur@exemple.com'],
                'constraints' => [
                    new NotBlank(['message' => "L'e-mail est obligatoire."]),
                    new Email(['message' => 'Adresse e-mail invalide.']),
                ],
            ])
            ->add('telephone', TelType::class, [
                'label'    => 'Téléphone',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => '+228 XX XX XX XX'],
            ])
            ->add('roles', ChoiceType::class, [
                'label'    => 'Rôle',
                'choices'  => [
                    'Utilisateur'     => 'ROLE_USER',
                    'Administrateur'  => 'ROLE_ADMIN',
                    'Établissement'   => 'ROLE_ETABLISSEMENT',
                ],
                'multiple' => true,
                'expanded' => true,
                'attr'     => ['class' => 'form-check-input'],
            ])
            ->add('actif', CheckboxType::class, [
                'label'    => 'Compte actif',
                'required' => false,
                'attr'     => ['class' => 'form-check-input'],
            ]);

        if (!$isEdit) {
            $builder->add('plainPassword', PasswordType::class, [
                'label'    => 'Mot de passe',
                'mapped'   => false,
                'required' => true,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Mot de passe initial'],
                'constraints' => [
                    new NotBlank(['message' => 'Le mot de passe est obligatoire.']),
                    new Length(['min' => 6, 'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.']),
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit'    => false,
        ]);
    }
}
