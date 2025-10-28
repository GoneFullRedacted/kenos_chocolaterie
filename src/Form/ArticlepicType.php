<?php

namespace App\Form;


use App\Entity\Articlepic;
// use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticlepicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('picFile', FileType::class, [
                'label' => 'Images (JPG, PNG ou Web)',
                'mapped' => false,
                'required' => false,
                // 'multiple' => true,
                'attr' => [
                    'accept' => 'image/*',
                    'class' => 'file-input'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPG, PNG ou WebP)',
                    ])
                ],
            ])

            ->add('alttxt', TextType::class, [
                'label' => 'Texte alternatif'
            ])
        ;
        // $builder
        //     ->add('pic')
        //     ->add('article', EntityType::class, [
        //         'class' => Article::class,
        //         'choice_label' => 'id',
        //     ])
        // ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articlepic::class,
        ]);
    }
}
