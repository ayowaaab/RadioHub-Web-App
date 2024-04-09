<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bodypart')
            ->add('patient')
            ->add('aquisationDate',DateType::class,[
                'widget'=>'single_text',])

                ->add('filename', FileType::class, [
                    'label' => 'filename',
            
                    // unmapped means that this field is not associated with any entity property
                    'mapped' => false,
            
                    // make it optional so you don't have to re-upload the PDF file
                    // every time you edit the Product details
                    'required' => false,
                    'constraints' => [
                        new Assert\NotBlank(message: "This field cannot be blank."),
            
                        new Assert\File([
                            'maxSize' => '1024k',
                            'mimeTypesMessage' => 'Please upload a valid DICOM file',
                            'mimeTypes' => ['application/dicom'], // Define the MIME type for DICOM files
                        ]),
                    ],
                ])

                ->add("save", SubmitType::class, [
                    'label' => 'Save Changes',
                    'attr' => ['class' => 'btn btn-primary']
                ]);       ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
