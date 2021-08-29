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
                'choices'  => CalculatorEnum::productType
            ])
            ->add('age',NumberType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => CalculatorEnum::genderValues
            ])
            ->add('height', ChoiceType::class, [
            'choices' => CalculatorEnum::heightValues
            ])
            ->add('weight', ChoiceType::class, [
                'choices' => CalculatorEnum::weightValues
            ])
            ->add('creditRating', ChoiceType::class, [
                'choices' => CalculatorEnum::creditRating
            ])
            ->add('paymentStartDate', TextType::class)
            ->add('paymentEndDate', TextType::class)
            ->add('paymentAmount', TextType::class)
            ->add('frequency', ChoiceType::class, [
                'choices' => CalculatorEnum::frequencyValues
            ])
            ->add('percentStep', TextType::class)
            ->add('phoneNo', TextType::class)
            ->add('emailAddress', TextType::class)
            ->add('smoker' , ChoiceType::class, [
                'choices' => CalculatorEnum::smokerValues
            ])
            ->add('healthStatus' , ChoiceType::class, [
                'choices' => CalculatorEnum::healthStatus
            ])
            ->add('legalIssues' , ChoiceType::class, [
                'choices' => CalculatorEnum::legalIssues
            ])
            ->add('DUI' , ChoiceType::class, [
                'choices' => CalculatorEnum::DUIValues
            ])
            ->add('licenseSuspended', ChoiceType::class, [
                'choices' => CalculatorEnum::licenseSuspended
            ])
            ->add('misdemeanor', ChoiceType::class, [
                'choices' => CalculatorEnum::misdemeanorValues
            ])
            ->add('annualCheckup', ChoiceType::class, [
                'choices' => CalculatorEnum::annualCheckUpStatus
            ])
            ->add('physicalExercise', ChoiceType::class, [
                'choices' => CalculatorEnum::physicalExerciseStatus
            ])
            ->add('bloodPressure', ChoiceType::class, [
                'choices' => CalculatorEnum::bloodPressureStatus
            ])
            ->add('highCholesterol', ChoiceType::class, [
                'choices' => CalculatorEnum::cholesterolStatus
            ])
            ->add('drivingInfraction', ChoiceType::class, [
                'choices' => CalculatorEnum::drivingInfractionsStatus
            ]);
    }
}
