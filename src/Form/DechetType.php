<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Dechet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DechetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('description')
            ->add('prix')
            ->add('promo', CheckboxType::class, [
                'label' => 'En Promotion',
                'required' => false
            ])
            ->add('quantiteStock')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => function ($categorie) {
                    return $categorie->getNomCategorie();
                }
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('ville')
            ->add('adresse')
            ->add('CodePostal', TextType::class, [
                'label' => 'Code Postal '
            ])
            ->add('origine', ChoiceType::class, [
                'choices' => $this->getChoicesOrigine()
            ])
            ->add('nature', ChoiceType::class, [
                'choices' => $this->getChoicesNature()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dechet::class,
        ]);
    }
    public function getChoicesOrigine()
    {
        $choices = Dechet::ORIGINE;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
    public function getChoicesNature()
    {
        $choices = Dechet::NATURE;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}