<?php

namespace App\Form;

use App\Entity\Store;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class StoreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du magasin'
                ]])
            ->add('province', ChoiceType::class, [
                'choices'  => [
                    'Anvers' => 'Anvers',
                    'Brabant flamand' => 'Brabant flamand',
                    'Brabant wallon' => 'Brabant wallon',
                    'Flandre' => 'Flandre',
                    'Hainaut' => 'Hainaut',
                    'Liège' => 'Liège',
                    'Limbourg' => 'Limbourg',
                    'Luxembourg' => 'Luxembourg',
                    'Namur' => 'Namur',

                ]])
            ->add('ville', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de la ville'
                ]])
            ->add('street', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de la rue'
                ]])
            ->add('number', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Numéro'
                ]])
            ->add('submit', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-light'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" =>  Store::class
        ]);
    }
}
