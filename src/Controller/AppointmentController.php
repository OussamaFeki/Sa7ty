<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Doctor;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use App\Repository\DoctorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/appointment')]
class AppointmentController extends AbstractController
{
    #[Route('/booking', name: 'app_appointment_booking', methods: ['GET'])]
    public function appointmentBooking(AppointmentRepository $appointmentRepository,DoctorRepository $doctorRepository ): Response
    {
        return $this->render('appointment/app_appointment_booking.twig', [
            'appointments' => $appointmentRepository->findAll(),
            'doctors' => $doctorRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_appointment_index', methods: ['GET'])]
    public function index(AppointmentRepository $appointmentRepository,DoctorRepository $doctorRepository ): Response
    {
        return $this->render('appointment/index.html.twig', [
            'appointments' => $appointmentRepository->findAll(),'doctors' => $doctorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_appointment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appointment);
            $entityManager->flush();

            return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appointment/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appointment_show', methods: ['GET'])]
    public function show(Appointment $appointment): Response
    {
        return $this->render('appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_appointment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appointment/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appointment_delete', methods: ['POST'])]
    public function delete(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/new_booking/{doctorId}/{dateTimeStamp}/{startAt}', name: 'app_appointment_book_now', methods: ['GET', 'POST'])]
    public function bookNow(int $doctorId, int $dateTimeStamp, int $startAt, Request $request, EntityManagerInterface $entityManager, DoctorRepository $doctorRepository): Response
    {
        // Check if the logged-in user has the 'Patient' role
        if (in_array('ROLE_PATIENT', $this->getUser()->getRoles())) {
            $doctor = $doctorRepository->find($doctorId);
            if (!$doctor) {
                throw $this->createNotFoundException('No doctor found for id ' . $doctorId);
            }
    
            // Create a new Appointment entity
            $appointment = new Appointment();
            $appointment->setDoctor($doctor);
            $appointment->setPatient($this->getUser()->getPatient());
            
            // Convert timestamp to DateTime object
            $appointmentDate = new \DateTime();
            $appointmentDate->setTimestamp($dateTimeStamp);
            $appointment->setDate($dateTimeStamp);
            
            // Set start time (assuming $startAt is in seconds, e.g., 3600 for 1 hour)
            $startHour = (int)($startAt / 3600);
            $appointment->setHour($startHour);
            
            $appointment->setProgress("RESERVED");
    
            // Persist the appointment
            $entityManager->persist($appointment);
            $entityManager->flush();
    
            // Add flash message
            $this->addFlash('success', 'Appointment successfully booked.');
    
            // Redirect to the appointment show page
            return $this->redirectToRoute('app_appointment_show', ['id' => $appointment->getId()]);
        }
    
        // If the user is not a patient or not logged in, redirect to a login page or deny access
        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }
    
    
}
