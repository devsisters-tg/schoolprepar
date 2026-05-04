<?php

namespace App\Form;

use App\Entity\Etablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'       => 'Nom de l\'établissement',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'Ex : Institut Polytechnique de Lomé'],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom de l\'établissement est obligatoire.']),
                    new Length(['min' => 3, 'max' => 200,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.']),
                ],
            ])
            ->add('sigle', TextType::class, [
                'label'    => 'Sigle / Acronyme',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : IPNIT'],
            ])
            ->add('ville', TextType::class, [
                'label'       => 'Ville',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'Ex : Lomé'],
                'constraints' => [
                    new NotBlank(['message' => 'La ville est obligatoire.']),
                    new Length(['max' => 100, 'maxMessage' => 'La ville ne peut pas dépasser {{ limit }} caractères.']),
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label'    => 'Type d\'établissement',
                'required' => false,
                'placeholder' => '-- Choisir un type --',
                'attr'     => ['class' => 'form-select'],
                'choices'  => [
                    'Université publique'   => 'Université publique',
                    'Université privée'     => 'Université privée',
                    'Institut privé'        => 'Institut privé',
                    'École professionnelle' => 'École professionnelle',
                    'Grande école'          => 'Grande école',
                    'Autre'                 => 'Autre',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Décrivez brièvement cet établissement...'],
            ])
            ->add('email', EmailType::class, [
                'label'    => 'Email de contact',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'contact@ecole.tg'],
                'constraints' => [
                    new Email(['message' => 'L\'adresse e-mail de contact est invalide.']),
                ],
            ])
            ->add('telephone', TelType::class, [
                'label'    => 'Téléphone',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => '+228 XX XX XX XX'],
                'constraints' => [
                    new Length(['max' => 30, 'maxMessage' => 'Le numéro de téléphone ne peut pas dépasser {{ limit }} caractères.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Etablissement::class]);
    }
}
