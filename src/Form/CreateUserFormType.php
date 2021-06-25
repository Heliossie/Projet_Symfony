<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
            ])
            ->add('surname', null, [
                'label' => 'Surnom',
            ])
            ->add('adress', null, [
                'label' => 'Adresse',
            ])
            ->add('zip_code', null, [
                'label' => 'Code postal',
            ])
            ->add('city', null, [
                'label' => 'Ville',
            ])
            ->add('state', null, [
                'label' => 'Pays',
            ])
            ->add('phone', null, [
                'label' => 'Telephone',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ])
            ->add('save', SubmitType::class, ['label' => "S'inscrire"])
    ;}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class_client' => Client::class,
        ]);
    }
}
