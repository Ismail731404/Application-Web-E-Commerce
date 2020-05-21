<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Categorie;
use App\Entity\Dechet;
use App\Entity\DechetRecherche;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q',TextType::class,[
                'label'=> false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            
            ->add('categories',EntityType::class,[
                'required' => false,
                'label' => false,
                'class' => Categorie::class,
                'expanded' => true
                
                
            ])
            ->add('max',NumberType::class,[
                'required' => false,
                'label' =>false,
                'attr' => [
                    'placeholder' => 'Prix maximal'
                ]
            ])
            ->add('min',NumberType::class,[
                'required' => false,
                'label' =>false,
                'attr' => [
                    'placeholder' => 'Prix minumum '
                ]
            ])
            ->add('origine',ChoiceType::class,[
                'required' => false,
                'label' =>false,
                'expanded' => true,
                'choices' =>$this->getChoicesOrigine()
            ])
            ->add('promo',CheckboxType::class,[
                'label' => 'En promotion',
                'required' => false,
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false

        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
    public function getChoicesOrigine()
    {
        $choices = Dechet::ORIGINE;
        $output = [];
        foreach ($choices as $k => $v)
        {
            $output[$v] =$k;
        }
        return $output;

    }
    

}