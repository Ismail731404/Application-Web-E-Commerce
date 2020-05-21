<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ResetPassAfterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, [
                'label' => 'Mots de passe',
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/",
                        'htmlPattern' => "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$",
                        'match' => 'true',
                        'message' => "Un bon mots de passe commence par une lettre avec au moins un chiffre et les symbole[#,-_.]"
                    ]),
                    new Length(['min' => '8', 'minMessage' => 'Votre mots doivent au moins avoir 8 caractere']),

                ],
                'attr' => ['placeholder' => 'Tapez votre nouveau mdp'],
            ])
            ->add('confirmepassword', PasswordType::class, [
                'label' => 'Comfirmation',
                'attr' => ['placeholder' => 'Confirmer votre nouveau mdp'],
            ])
            ->add('envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}