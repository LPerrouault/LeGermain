<?php

namespace App\Form;

use App\Entity\Oeuvre;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class OeuvreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,[
                'attr'=>['class'=>'form-controle']
            ])
            ->add('listeTags',\Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                'class' => 'App\Entity\Tag',
                'mapped' => false,
                'choice_label' => 'libelle',
                'attr' =>['class' =>'form-controle']))
            ->add('idType', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                'class' => 'App\Entity\Type',
                'mapped' => false,
                'choice_label' => 'libelle',
                'attr' =>['class' =>'form-select']))

            ->add('largeur', TextType::class,[
            'attr'=>['class'=>'form-controle']
            ])
            ->add('hauteur', TextType::class,[
                'attr'=>['class'=>'form-controle']
            ])
            ->add('nomFichierImage', FileType::class,[
                'label' => false,
                'mapped' => false,
                'attr'=>['class'=>'form-control-file'],
                'required' => true,
                'constraints' => [
                    new Image()
                ]
            ])
            ->add('description',CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                    'toolbar' => 'standard')))
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
            'data_class' => Oeuvre::class,
        ]);
    }
}
