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
            'placeholder' => false,
            'choices' => CalculatorEnum::productType,
            'required' => true,
            'data' => 'lcp'
        ])
            ->add('age', TextType::class, [
                'attr' => ['class' => 'form-input number-input', 'autocomplete' => 'off', 'min' => 20],
                'required' => true,
            ])
            ->add('gender', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled', 'autocomplete' => 'off',],
                'required' => false,
                'choices' => CalculatorEnum::genderValuesKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false

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
                'data' => 'others'
            ])
            ->add('paymentStartDate', TextType::class, [
                'attr' => ['class' => 'form-input inp-required', 'autocomplete' => 'off', 'readonly' => true],
                'required' => true,
            ])
            ->add('paymentEndDate', TextType::class, [
                'attr' => ['class' => 'form-input inp-required', 'autocomplete' => 'off', 'readonly' => true],
                'required' => true,
            ])
            ->add('paymentAmount', TextType::class, [
                'attr' => ['class' => 'form-input number-input', 'autocomplete' => 'off', 'min' => 0],
                'required' => true,
            ])
            ->add('frequency', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled', 'autocomplete' => 'off'],
                'placeholder' => false,
                'required' => true,
                'choices' => CalculatorEnum::frequencyValues,
                'data' =>'Weekly'
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
                'placeholder' => false,
                'required' => false,
                'choices' => CalculatorEnum::smokerValuesKeys,
                'data' => 'Yes'
            ])
            ->add('healthStatus', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'placeholder' => false,
                'required' => false,
                'choices' => CalculatorEnum::healthStatusKeys,
                'data' => 'Normal'
            ])
            ->add('legalIssues', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::legalIssuesKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false
            ])
            ->add('DUI', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::DUIValuesKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false

            ])
            ->add('licenseSuspended', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::licenseSuspendedKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false
            ])
            ->add('misdemeanor', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::misdemeanorValuesKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false
            ])
            ->add('annualCheckup', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::annualCheckUpStatusKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false
            ])
            ->add('physicalExercise', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::physicalExerciseStatusKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false
            ])
            ->add('bloodPressure', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::bloodPressureStatusKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false
            ])
            ->add('highCholesterol', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::cholesterolStatusKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false
            ])
            ->add('drivingInfraction', ChoiceType::class, [
                'attr' => ['class' => 'form-input filled inp-required', 'autocomplete' => 'off'],
                'required' => false,
                'choices' => CalculatorEnum::drivingInfractionsStatusKeys,
                'data' => 'Prefer Not To Answer',
                'placeholder' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'insuranceCompanies' => null,
        ]);
    }
}
