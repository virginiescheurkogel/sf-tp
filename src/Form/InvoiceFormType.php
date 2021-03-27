<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                "label" => "Date de le facture",
                "widget" => "single_text"
            ])
            ->add('number', TextType::class, ["label" =>"Numéro de facture"])
            ->add('discountRate', TextType::class, ["label" =>"Remise"])
            ->add('items', TextType::class, ["label" => "Désignation"])
            //->add('client')
            ->add('Valider', SubmitType::class, ["attr" => ["class" =>"btn btn-primary mt-3"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
