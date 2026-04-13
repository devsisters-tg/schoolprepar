<?php

namespace App\Form;

use App\Entity\Etablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'établissement',
                'attr'  => ['class' => 'form-control'],
            ])
            ->add('sigle', TextType::class, [
                'label'    => 'Sigle',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : IPNIT'],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr'  => ['class' => 'form-control', 'placeholder' => 'Ex : Lomé'],
            ])
            ->add('type', TextType::class, [
                'label'    => 'Type',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : Institut Privé'],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 4],
            ])
            ->add('email', TextType::class, [
                'label'    => 'Email de contact',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'contact@ecole.tg'],
            ])
            ->add('telephone', TextType::class, [
                'label'    => 'Téléphone',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => '+228 XX XX XX XX'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Etablissement::class]);
    }
}
