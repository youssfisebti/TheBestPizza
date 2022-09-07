<?php

namespace App\Form;

use App\Entity\Allergies;
use App\Entity\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AllergiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'label' => 'Les ingrédients',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Sauvgarder'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Allergies::class,
        ]);
    }
}
