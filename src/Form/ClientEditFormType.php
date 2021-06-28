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

class ClientEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['label' => 'Nom'])
            ->add('surname',TextType::class,['label' => 'Prénom'])
            ->add('adress',TextType::class,['label' => 'Adresse'])
            ->add('zip_code',TextType::class,['label' => 'Code postale'])
            ->add('city',TextType::class,['label' => 'Ville'])
            ->add('state',TextType::class,['label' => 'Pays'])
            ->add('phone',TelType::class,['label' =>'Téléphone'])
            ->add('email',EmailType::class)
            ->add('edit',SubmitType::class,['label' =>'Modifier'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}