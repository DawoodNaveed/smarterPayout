<?php

namespace App\Form;

use App\Helper\CustomHelper;
use Symfony\Component\Form\AbstractType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class userForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'Enter your email here'],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'form-control',
                    'placeholder' => 'Enter your password here']],
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password']
            ])
            ->add('username', TextType::class, [
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'Enter your username here'],
            ])
            ->add('businessPhone', TelType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'Enter your business phone here',
                    'pattern' => '^(\+|00)[0-9]{1,3}[0-9]{4,14}$'
                ]
            ])
            ->add('jobTitle', TextType::class, [
                'attr' => ['class' => 'form-control',
                    'placeholder' => 'Enter your job title here'],
            ])
            ->add('phoneNumber', TelType::class, [
                'required' => false, 'attr' => ['class' => 'form-control',
                    'placeholder' => 'Enter your phone number here','pattern' => '^(\+|00)[0-9]{1,3}[0-9]{4,14}$'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => CustomHelper::ROLES,
                'required' => true,
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
