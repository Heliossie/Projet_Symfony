<?php

namespace App\Form;

use App\Entity\Admin;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('adress')
            ->add('zip_code')
            ->add('city')
            ->add('state')
            ->add('phone')
            ->add('email')
            ->add('identifiant',TextType::class, ['mapped' => false])
            ->add('password1',PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false])
            // ->add('password2',PasswordType::class, [
            //     'label' => ' Confirmez le mot de passe',
            //     'mapped' => false])
            ->add('Valider', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
