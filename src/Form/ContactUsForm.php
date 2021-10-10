<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ContactUsForm
 * @package App\Form
 */
class ContactUsForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('contact', TelType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'autocomplete' => 'off',
                    'pattern' => '^[+]?\d{1,2}([\s]?)\(?[0-9]{3}[)]([\s]?)[0-9]{3}-[0-9]{4}$'
                ]
            ]);
    }
}
