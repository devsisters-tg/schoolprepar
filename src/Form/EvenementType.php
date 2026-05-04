<?php

namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\Evenement;
use App\Entity\Filiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label'       => 'Titre de l\'événement',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'Ex : Journée Portes Ouvertes 2025'],
                'constraints' => [
                    new NotBlank(['message' => 'Le titre de l\'événement est obligatoire.']),
                    new Length(['min' => 5, 'max' => 255,
                        'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le titre ne peut pas dépasser {{ limit }} caractères.']),
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label'       => 'Type d\'événement',
                'required'    => false,
                'placeholder' => '-- Choisir un type --',
                'attr'        => ['class' => 'form-select'],
                'choices'     => [
                    'Journée Portes Ouvertes' => 'JPO',
                    'Webinaire'               => 'Webinaire',
                    'Salon'                   => 'Salon',
                    'Conférence'              => 'Conférence',
                    'Concours'                => 'Concours',
                    'Atelier'                 => 'Atelier',
                    'Autre'                   => 'Autre',
                ],
            ])
            ->add('dateEvenement', DateTimeType::class, [
                'label'       => 'Date et heure de l\'événement',
                'widget'      => 'single_text',
                'attr'        => ['class' => 'form-control'],
                'constraints' => [
                    new NotNull(['message' => 'La date de l\'événement est obligatoire.']),
                ],
            ])
            ->add('lieu', TextType::class, [
                'label'    => 'Lieu',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : Lomé, Campus IPNIT'],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Décrivez cet événement...'],
            ])
            ->add('filiere', EntityType::class, [
                'class'        => Filiere::class,
                'choice_label' => 'nom',
                'placeholder'  => '-- Toutes filières --',
                'required'     => false,
                'label'        => 'Filière concernée',
                'attr'         => ['class' => 'form-select'],
            ])
            ->add('etablissement', EntityType::class, [
                'class'        => Etablissement::class,
                'choice_label' => 'nom',
                'placeholder'  => '-- Tous établissements --',
                'required'     => false,
                'label'        => 'Établissement organisateur',
                'attr'         => ['class' => 'form-select'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Evenement::class]);
    }
}
