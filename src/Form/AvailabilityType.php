<?php

namespace App\Form;

use App\Entity\Availability;
use App\Entity\Doctor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('consultation_duration')
            ->add('mon_start_hour')
            ->add('mon_end_hour')
            ->add('tue_start_hour')
            ->add('tue_end_hour')
            ->add('wed_start_hour')
            ->add('wed_end_hour')
            ->add('thu_start_hour')
            ->add('thu_end_hour')
            ->add('sat_start_hour')
            ->add('sat_end_hour')
            ->add('fri_start_hour')
            ->add('fri_end_hour')
            ->add('sun_start_hour')
            ->add('sun_end_hour')
            ->add('doctor', EntityType::class, [
                'class' => Doctor::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Availability::class,
        ]);
    }
}
