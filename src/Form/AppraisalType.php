<?php


namespace App\Form;

use App\Entity\{Appraisal,Car};
use App\Repository\AppraisalRepository;
use App\Repository\CarRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType, NumberType};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

class AppraisalType extends AbstractType
{

    private $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('car', EntityType::class, [
                'class' => Car::class,
            ])
            ->add('salePrice', NumberType::class)
            ->add('repairPrice', NumberType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Contract' => 'contract',
                    'Comission' => 'comission'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Appraisal::class,
        ]);
    }
}