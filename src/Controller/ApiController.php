<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Patient;
use App\Entity\Doctor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/api/user/add/patient', name: 'add_patient', methods: ['POST'])]
    public function addPatient(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_PATIENT']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPhone($data['phone']);
        $user->setGender($data['gender']);
        // $user->setBirthdate(new \DateTime($data['birthdate']));
        $user->setBirthdate((new \DateTime())->getTimestamp());
        $user->setCreationDate((new \DateTime())->getTimestamp());

        $patient = new Patient();
        $patient->setRegion($data['region']);
        $user->setPatient($patient);

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($user);
        $this->entityManager->persist($patient);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Patient created!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/user/add/doctor', name: 'add_doctor', methods: ['POST'])]
    public function addDoctor(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_DOCTOR']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPhone($data['phone']);
        $user->setGender($data['gender']);
        // $user->setBirthdate(new \DateTime($data['birthdate']));
        $user->setBirthdate((new \DateTime())->getTimestamp());
        $user->setCreationDate((new \DateTime())->getTimestamp());


        $doctor = new Doctor();
        $doctor->setSpecialty($data['specialty']);
        $doctor->setOfficeRegion($data['officeRegion']);
        $doctor->setOfficeAddress($data['officeAddress']);
        $doctor->setOfficePhone($data['officePhone']);
        $user->setDoctor($doctor);

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($user);
        $this->entityManager->persist($doctor);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Doctor created!'], JsonResponse::HTTP_CREATED);
    }
}
