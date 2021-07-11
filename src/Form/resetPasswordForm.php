<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class resetPasswordForm
 * @package App\Form
 */
class resetPasswordForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options' => ['label' => 'New password',
                    'attr' => ['class' => 'form-control custom-input text-indent',
                        'placeholder' => 'Password']],
                'second_options' => ['label' => 'Repeat new password',
                    'attr' => ['class' => 'form-control custom-input text-indent',
                        'placeholder' => 'Confirm Password']],
            ]);
    }
}