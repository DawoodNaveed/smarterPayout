<?php

namespace App\Form;

use App\Enum\CalculatorEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CalculatorForm
 * @package App\Form
 */
class CalculatorForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('productType', ChoiceType::class, [
            'attr' => ['class' => 'form-input filled', 'autocomplete' => 'off'],
            'placeholder' => '',
            'choices' => CalculatorEnum::productType,
            'required' => true
        ])
            ->add('age', TextType::class, [
                'attr' => ['class' => 'form-input number-input', 'autocomplete' => 'off', 'min' => 20],
                'required' => true,
            ])
            ->add('gender', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled', 'autocomplete' => 'off',],
                'required' => false,
                'choices' => CalculatorEnum::genderValuesKeys,
                'placeholder' => ''

            ])
            ->add('firstName', TextType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => true,
            ])
            ->add('lastName', TextType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => false,
            ])
            ->add('weight', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled', 'autocomplete' => 'off'],
                'choices' => CalculatorEnum::weightValuesKeys,
                'required' => false,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false
            ])
            ->add('height', TextType::class, ['required' => false])
            ->add('creditRating', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => $options['insuranceCompanies'],
                'data' => 'Others'
            ])
            ->add('paymentStartDate', TextType::class, [
                'attr' => ['class' => 'form-input inp-required', 'autocomplete' => 'off'],
                'required' => true,
            ])
            ->add('paymentEndDate', TextType::class, [
                'attr' => ['class' => 'form-input inp-required', 'autocomplete' => 'off'],
                'required' => true,
            ])
            ->add('paymentAmount', TextType::class, [
                'attr' => ['class' => 'form-input number-input', 'autocomplete' => 'off', 'min' => 0],
                'required' => true,
            ])
            ->add('frequency', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => true,
                'choices' => CalculatorEnum::frequencyValues
            ])
            ->add('percentStep', TextType::class, [
                'attr' => ['class' => 'form-input number-input', 'autocomplete' => 'off', 'min' => 0, 'max' => 10],
                'required' => false,
            ])
            ->add('phoneNo', TelType::class, [
                'attr' => ['class' => 'form-input filled static phone-input', 'autocomplete' => 'off'],
                'required' => false,
            ])
            ->add('emailAddress', EmailType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => false,
            ])
            ->add('smoker', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::smokerValuesKeys,
            ])
            ->add('healthStatus', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::healthStatusKeys,
            ])
            ->add('legalIssues', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::legalIssuesKeys,
                'placeholder' => ''
            ])
            ->add('DUI', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::DUIValuesKeys,
                'placeholder' => ''

            ])
            ->add('licenseSuspended', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::licenseSuspendedKeys,
                'placeholder' => ''
            ])
            ->add('misdemeanor', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::misdemeanorValuesKeys,
                'placeholder' => ''
            ])
            ->add('annualCheckup', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::annualCheckUpStatusKeys,
                'placeholder' => ''
            ])
            ->add('physicalExercise', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::physicalExerciseStatusKeys,
                'placeholder' => ''
            ])
            ->add('bloodPressure', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::bloodPressureStatusKeys,
                'placeholder' => ''
            ])
            ->add('highCholesterol', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::cholesterolStatusKeys,
                'placeholder' => ''
            ])
            ->add('drivingInfraction', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::drivingInfractionsStatusKeys,
                'placeholder' => ''
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'insuranceCompanies' => null,
        ]);
    }
}
