<?php

namespace App\Form;

use App\Enum\CalculatorEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
            'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
            'placeholder' => '',
            'choices' => CalculatorEnum::productType,
            'required' => false,
        ])
            ->add('age', TextType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => true,
            ])
            ->add('gender', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::genderValues
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
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'choices' => CalculatorEnum::weightValuesKeys,
                'required' => false,
            ])
            ->add('height', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'choices' => CalculatorEnum::heightValues,
                'required' => false,
            ])
            ->add('creditRating', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => true,
                'choices' => CalculatorEnum::creditRating
            ])
            ->add('paymentStartDate', TextType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => true,
            ])
            ->add('paymentEndDate', TextType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => true,
            ])
            ->add('paymentAmount', TextType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => true,
            ])
            ->add('frequency', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => true,
                'choices' => CalculatorEnum::frequencyValues
            ])
            ->add('percentStep', TextType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => false,
            ])
            ->add('phoneNo', TextType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => false,
            ])
            ->add('emailAddress', TextType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'required' => false,
            ])
            ->add('smoker', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::smokerValuesKeys
            ])
            ->add('healthStatus', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::healthStatusKeys
            ])
            ->add('legalIssues', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::legalIssuesKeys
            ])
            ->add('DUI', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::DUIValuesKeys
            ])
            ->add('licenseSuspended', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::licenseSuspendedKeys
            ])
            ->add('misdemeanor', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::misdemeanorValuesKeys
            ])
            ->add('annualCheckup', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::annualCheckUpStatusKeys
            ])
            ->add('physicalExercise', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::physicalExerciseStatusKeys
            ])
            ->add('bloodPressure', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::bloodPressureStatusKeys
            ])
            ->add('highCholesterol', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::cholesterolStatusKeys
            ])
            ->add('drivingInfraction', ChoiceType::class, [
                'attr' => ['class' => 'form-input', 'autocomplete' => 'off'],
                'placeholder' => '',
                'required' => false,
                'choices' => CalculatorEnum::drivingInfractionsStatusKeys
            ]);
    }
}
