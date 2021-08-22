<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class genericAudioForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('audioText', TextareaType::class, [
                'attr' => ['class' => 'form-control textarea-scroll', 'readonly' => 'true', 'rows'=> '2'],
            ])
            ->add('audioFile', FileType::class)
            ->add('tagId', TextType::class);
    }
}