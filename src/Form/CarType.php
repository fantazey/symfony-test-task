<?php


namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{TextType,NumberType,IntegerType};
use Symfony\Component\Form\FormBuilderInterface;

class CarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('producer', TextType::class)
            ->add('model', TextType::class)
            ->add('year', NumberType::class)
            ->add('vin', TextType::class)
            ->add('color', TextType::class)
            ->add('mileage', IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
            'csrf_protection' => false,
        ]);
    }
}