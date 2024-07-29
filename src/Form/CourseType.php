<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom du cours",
            ])
            ->add('content', TextareaType::class, [
                'label' => "Contenu du cours",
            ])
            ->add('duration', IntegerType::class, [
                'label' => "Duree du cours (en jours)",
            ])
            ->add('published', CheckboxType::class, [
                'label' => "Cours publie ?",
                'required' => false,
            ])
            ->add(
                'categories',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Sélectionnez une catégorie',
                    'multiple' => true
                ]
            )
//            ->add('thumbnailFile', FileType::class)
            ->add('addCourse', SubmitType::class, [
                'label' => "Ajouter un cours",
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;

        /* Sans VichUploaderBundle
        ->add('thumbnailFile', FileType::class, [
            'label' => "Miniature du cours",
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new Image([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Veuillez uploader une image au format jpg ou png',
                ])
            ],
        ])*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
