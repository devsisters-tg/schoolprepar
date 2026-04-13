<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Etablissement;
use App\Entity\Filiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de l\'événement',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('type', TextType::class, [
                'label'    => 'Type',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : Webinaire, Salon, JPO'],
            ])
            ->add('dateEvenement', DateTimeType::class, [
                'label'  => 'Date et heure',
                'widget' => 'single_text',
                'attr'   => ['class' => 'form-control'],
            ])
            ->add('lieu', TextType::class, [
                'label'    => 'Lieu',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : Lomé, IPNIT'],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 4],
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Evenement::class]);
    }
}
