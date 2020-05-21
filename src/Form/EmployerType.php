<?php

namespace App\Form;

use App\Form\UserType;
use App\Entity\Employer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Departement', ChoiceType::class, [
                'choices'  => [
                    'Stock' => 'Stock',
                    'Vend' => 'Vend'
                ]

            ])
            ->add('Bureau', TextType::class, [
                'label' => 'Bureau'
            ])
            ->add('NumeroBureau', NumberType::class, [
                'label' => 'Numero fix du bureau'
            ])
            ->add('Fonction', TextType::class, [
                'label' => 'Fonction occuppe'
            ])
            ->add('foo', UserType::class, [
                'data_class' => Employer::class,
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employer::class,
        ]);
    }
}