<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // ajouter champ password à vérifier avec celui du getUser
        // ->add('password',EmailType::class, [
        //     'label' => 'Veuillez entrer votre mot de passe actuel'
        // ])
        // ->addEventListener(
        //     FormEvents::PRE_SET_DATA,
        //     [$this, 'onPreSetData']
        // )

        ->add('password',RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Le mot de passe doit être le même.',
            'required' => true,
            'first_options' => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmez le mot de passe'],
        ])

        ->add('Modifier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
