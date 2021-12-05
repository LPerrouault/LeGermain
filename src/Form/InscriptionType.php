<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Inscription;
use libphonenumber\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>['class'=>'form-text']
            ])
            ->add('prenom', TextType::class,[
                'attr'=>['class'=>'form-text']
            ])
            ->add('email', EmailType::class,[
                'attr'=>['class'=>'form-text'],
            ])
            ->add('telephone', NumberType::class)
            ->add('message', TextareaType::class,[
                'attr'=>['class'=>'form-text'],
            ])
            ->add('submit',SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' =>['class' =>'btn btn-primary']
            ])
            ->add('reset',ResetType::class, [
                'label' => 'Effacer',
                'attr' =>['class' =>'btn btn-danger']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
