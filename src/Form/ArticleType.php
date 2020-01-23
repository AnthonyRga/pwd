<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Store;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;




class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de la vapote'
                ]])
            ->add('model', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Modèle de la vapote'
                ]])
            ->add('price',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix'
                ]])
            ->add('power',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Puissance (watts)'
                ]])
            ->add('capacity',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Capacité (ml)'
                ]])
            ->add('lenght',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Hauteur (cm)'
                ]])
            ->add('diameter',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Diamètre (cm)'
                ]])
            ->add('autonomy',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Autonomie (mha)'
                ]])
            ->add('store',EntityType::class,[
                'class' => 'App\Entity\Store',
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control form-control-lg'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Upload une image (Condition: 400px sur 400px)',
                'data_class' => null,
            ])

            ->add('submit', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-light'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" =>  Article::class
        ]);
    }
}
