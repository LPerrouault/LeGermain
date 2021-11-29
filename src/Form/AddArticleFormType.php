<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticlesRepository;
use App\Repository\TagRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Validator\Constraints\File;


class AddArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class)
            ->add('listeTags',\Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                'class' => 'App\Entity\Tag',
                'mapped' => false,
                'choice_label' => 'libelle',))
            ->add('nomFichierImage', FileType::class,[
                'label' => false,
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/jpeg',
                            'application/jpg',
                            'application/png'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('corpsArticle',CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                    'toolbar' => 'standard')))

            ->setMethod(Request::METHOD_PUT)
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}
