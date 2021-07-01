<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['label' => 'Nom'])
            ->add('surname',TextType::class,['label' => 'Prénom'])
            ->add('adress',TextType::class,['label' => 'Adresse'])
            ->add('zip_code',TextType::class,['label' => 'Code postal'])
            ->add('city',TextType::class,['label' => 'Ville'])
            ->add('state',TextType::class,['label' => 'Pays'])
            ->add('phone',TelType::class,['label' =>'Téléphone'])
            ->add('email',EmailType::class)
            ->add('identifiant',TextType::class, ['mapped' => false])
            ->add('password',RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe doit être le même.',
                'required' => true,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
                'mapped' => false],)
            ->add('submit', SubmitType::class,['label' =>"S'abonner", "attr" => ['class' => 'btn btn-primary']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
