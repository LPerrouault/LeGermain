<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;


class AddArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /*
         * Creation du formulaire
         * titre -> titre de l'article
         * listtags-> liste des tage chant choiceType
         * nomfichier-> uploader de fichier
         * corrpsArticle-> chant pour rediger le contenue de l'article
         * les cotraintes 'attr' sert a mettre des class pour le CSS
         */
        $builder
            ->add('titre',TextType::class,[
                'attr'=>['class'=>'form-text']
            ])
            ->add('listeTags',\Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                'class' => 'App\Entity\Tag',
                'mapped' => false,
                'choice_label' => 'libelle',
                'attr' =>['class' =>'form-select']))
            ->add('nomFichierImage', FileType::class,[
                'label' => false,
                'mapped' => false,
                'attr'=>['class'=>'form-control-file'],
                'required' => true,
                'constraints' => [
                    new Image()
                ]
            ])
            ->add('corpsArticle',CKEditorType::class, array(
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
            'data_class' => Article::class,
        ]);
    }

}
