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

class ArticleEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('model', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('price',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('power',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('capacity',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('lenght',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('diameter',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('autonomy',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('store',EntityType::class,[
                'class' => 'App\Entity\Store',
                'choice_label' => 'name',
                'multiple' => true,

                'attr' => [
                    'class' => 'form-control form-control-lg'
                ]
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
