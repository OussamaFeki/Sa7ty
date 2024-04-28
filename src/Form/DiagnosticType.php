<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Psr\Log\LoggerInterface;

class DiagnosticType extends AbstractType
{
    private $httpClient;
    private $logger;

    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $symptoms = [];
        try {
            $response = $this->httpClient->request('GET', 'http://127.0.0.1:5000/symptoms');
            $symptomsData = $response->toArray();
            foreach ($symptomsData as $symptom) {
                $symptoms[$symptom] = $symptom;
            }
        } catch (ClientException $e) {
            $this->logger->error('API call failed', ['exception' => $e]);
            // Optionally add a user-friendly message or handle it differently
        }

        $builder
            ->add('symptoms', ChoiceType::class, [
                'choices' => $symptoms,
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'attr' => ['class' => 'form-control select-multiple'],
                'label' => 'Select Symptoms',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
