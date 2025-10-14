<?php

namespace App\Form;

use App\Entity\Coffeeshop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CoffeeshopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
     $builder
    ->add('name')
    ->add('location')
    ->add('availability')
    ->add('constructionDate', DateType::class, [
        'widget' => 'single_text',
        'required' => false
    ])
;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coffeeshop::class,
        ]);
    }
}
