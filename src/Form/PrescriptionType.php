<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Prescription;
use App\Service\ApiService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrescriptionType extends AbstractType
{
    private $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Fetch medicines from ApiService
        $medicines = $this->apiService->getAllMedicines();

        $builder
            ->add('medicines', ChoiceType::class, [
                'choices' => $medicines,
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'attr' => ['class' => 'form-control select-multiple'],
                'label' => 'Select Medicines',
            ])
            ->add('description')
            ->add('consultation', EntityType::class, [
                'class' => Consultation::class,
                'choice_label' => 'id',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
