<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EditProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('brand',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre marque préférée'
                ]])
            ->add('taste',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre goût préféré'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
