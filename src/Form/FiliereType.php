<?php

namespace App\Form;

use App\Entity\Filiere;
use App\Entity\Etablissement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiliereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la filière',
                'attr'  => ['class' => 'form-control', 'placeholder' => 'Ex : Génie Logiciel'],
            ])
            ->add('niveau', TextType::class, [
                'label' => 'Niveau',
                'attr'  => ['class' => 'form-control', 'placeholder' => 'Ex : Licence 2'],
            ])
            ->add('duree', TextType::class, [
                'label'    => 'Durée',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : 3 ans'],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 4],
            ])
            ->add('debouches', TextareaType::class, [
                'label'    => 'Débouchés professionnels',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Ex : Développeur, Chef de projet...'],
            ])
            ->add('etablissements', EntityType::class, [
                'class'        => Etablissement::class,
                'choice_label' => 'nom',
                'multiple'     => true,
                'expanded'     => true,
                'required'     => false,
                'label'        => 'Établissements proposant cette filière',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Filiere::class]);
    }
}
