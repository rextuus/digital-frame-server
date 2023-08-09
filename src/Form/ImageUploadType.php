<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                'label' => 'Select an image',
                'attr' => ['accept' => 'image/*'],
            ])
            ->add('upload', SubmitType::class, [
                'label' => 'Upload',
                'attr' => ['class' => 'btn btn-primary', 'data-max-size' => $options['image_file_max_size']],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Set your desired data_class if needed
            // 'data_class' => YourEntityClass::class,
            'image_file_max_size' => 10 * 1024 * 1024,
        ]);
    }
}
/*
 *         $builder
            ->add('image', FileType::class, [
                'label' => 'Wähle/Erstelle ein Foto',
                // Allow only image files to be uploaded
                'attr' => ['accept' => 'image/*'],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Upload'])
        ;
 */