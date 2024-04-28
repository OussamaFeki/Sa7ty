<?php

namespace App\Controller;

use App\Form\DiagnosticType;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiagnosisController extends AbstractController
{
    private $apiService;

    public function __construct(ApiService $apiService) {
        $this->apiService = $apiService;
    }

    #[Route('/diagnosis', name: 'app_diagnosis')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(DiagnosticType::class);
        $form->handleRequest($request);
        $results = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $symptoms = $form->get('symptoms')->getData();
            $results = $this->apiService->getDiseasesBySymptoms($symptoms);
            // Store results in session or pass them directly if needed
            $request->getSession()->set('diagnosisResults', $results);

            return $this->redirectToRoute('app_diagnosis');  // Redirect to prevent re-submission
        }

        $results = $request->getSession()->get('diagnosisResults', []);
        $request->getSession()->remove('diagnosisResults');  // Clear the session after displaying

        return $this->render('diagnosis/index.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
        ]);
    }
}
