<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleSearchType extends AbstractType
{
    const PRICE = [25, 50, 75, 100, 200, 500];
    const LENGHT = [5, 10, 15, 20];
    const DIAMETER = [2, 2.5, 3, 3.5, 4, 4.5, 5];
    const CAPACITY = [5, 10, 20, 30, 40];
    const AUTONOMY = [600, 1000, 1400];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minimumPrice', ChoiceType::class, [
                'label' => 'Prix minimum',
                'choices' => array_combine(self::PRICE, self::PRICE),
            ])
            ->add('maximumPrice', ChoiceType::class, [
                'label' => 'Prix maximum ',
                'choices' => array_combine(self::PRICE, self::PRICE),
            ])
            ->add('lenght', ChoiceType::class, [
                'label' => 'Hauteur (cm)',
                'choices' => array_combine(self::LENGHT, self::LENGHT),
            ])
            ->add('diameter', ChoiceType::class, [
                'label' => 'Diamètre (cm)',
                'choices' => array_combine(self::DIAMETER, self::DIAMETER),
            ])
            ->add('capacity', ChoiceType::class, [
                'label' => 'Capacité (ml)',
                'choices' => array_combine(self::CAPACITY, self::CAPACITY),
            ])
            ->add('autonomy', ChoiceType::class, [
                'label' => 'Autonomie (mha)',
                'choices' => array_combine(self::AUTONOMY, self::AUTONOMY),
            ])
            ->add('rechercher' , SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-warning'
                ]
            ]);
    }

}
