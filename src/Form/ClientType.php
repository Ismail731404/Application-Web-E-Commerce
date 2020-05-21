<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Client;
use App\Form\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', VichFileType::class, [
                'label' => 'Raison Social',
                'attr' => ['placeholder' => 'Insert un Fichier pdf', 'name' => 'file'],
            ])
            ->add('foo', UserType::class, [
                'data_class' => Client::class,
                'label' => false
            ])
            ->add('terms', CheckboxType::class, [
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }

    // public function getName()
    // {
    //     return null;
    // }

    // public function getBlockPrefix()
    // {
    //     return "";
    // }
}