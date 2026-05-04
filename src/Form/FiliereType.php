<?php

namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\Filiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FiliereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'       => 'Intitulé de la filière',
                'attr'        => ['class' => 'form-control', 'placeholder' => 'Ex : Génie Logiciel'],
                'constraints' => [
                    new NotBlank(['message' => 'L\'intitulé de la filière est obligatoire.']),
                    new Length(['min' => 3, 'max' => 150,
                        'minMessage' => 'L\'intitulé doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'L\'intitulé ne peut pas dépasser {{ limit }} caractères.']),
                ],
            ])
            ->add('niveau', ChoiceType::class, [
                'label'   => 'Niveau d\'études',
                'attr'    => ['class' => 'form-select'],
                'choices' => [
                    'Licence 1'  => 'Licence 1',
                    'Licence 2'  => 'Licence 2',
                    'Licence 3'  => 'Licence 3',
                    'Master 1'   => 'Master 1',
                    'Master 2'   => 'Master 2',
                    'Doctorat'   => 'Doctorat',
                    'BTS'        => 'BTS',
                    'DUT'        => 'DUT',
                    'Ingénierie' => 'Ingénierie',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le niveau est obligatoire.']),
                ],
            ])
            ->add('duree', TextType::class, [
                'label'    => 'Durée de la formation',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : 3 ans, 2 semestres'],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description de la filière',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Décrivez le contenu et les objectifs de cette filière...'],
            ])
            ->add('debouches', TextareaType::class, [
                'label'    => 'Débouchés professionnels',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Ex : Développeur web, Chef de projet informatique, Architecte logiciel...'],
            ])
            ->add('etablissements', EntityType::class, [
                'class'        => Etablissement::class,
                'choice_label' => 'nom',
                'multiple'     => true,
                'expanded'     => true,
                'required'     => false,
                'label'        => 'Établissements proposant cette filière',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Filiere::class]);
    }
}
