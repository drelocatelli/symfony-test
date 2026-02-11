<?php

namespace App\Controller;

use App\Entity\Responsible;
use App\Entity\Student;
use App\Repository\ResponsibleRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class StudentController extends AbstractController
{
    public function __construct(
        private readonly StudentRepository $repository,
    ) {}
    
    #[Route('/student', name: 'app_student', methods: ['GET'])]
    public function index(
        SerializerInterface $serializer
    ): JsonResponse
    {
        $students = $this->repository->findAll();

        return $this->json($students);
    }

    #[Route('/student/{id}', name: 'app_student_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $student = $this->repository->find($id);

        return $this->json($student);
    }

    #[Route('/student', name: 'app_student_create', methods: ['POST'])]
    public function create(
        Request $req,
        #[MapRequestPayload] Student $payload,
        EntityManagerInterface $entityManager,
        ResponsibleRepository $responsibleRepository
    ): JsonResponse
    {

        $student = new Student();
        $student->setName($payload->getName());

        $request = json_decode($req->getContent());
        $responsibleId = $request->responsible;

        $responsible = $responsibleRepository->find($responsibleId);
        
        if(!$responsible) {
            throw $this->createNotFoundException("Responsible not found");
        }

        $student->setResponsible($responsible);

        $entityManager->persist($student);
        $entityManager->flush();
    
        return $this->json(["message" => "student created"], 201);
    }

    #[Route('/student/{id}', name: 'app_student_update', methods: ['PUT'])]
    public function update(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapRequestPayload] Student $payload,
        ResponsibleRepository $responsibleRepository
    ): JsonResponse
    {
        $student = $this->repository->find($id);

        if(!$student) {
            throw $this->createNotFoundException("student not found");
        }

        $responsibleId = $request->toArray()['responsible'] ?? null;

        if(!$responsibleId) {
            $responsibleId = $student->getResponsible();
        }

        $responsible = $responsibleRepository->find($responsibleId);

        $student->setName($payload->getName());
        $student->setResponsible($responsible);

        $entityManager->flush();
        
        return $this->json(["message" => "student updated"]);
    }

    #[Route('/student/{id}', name: 'app_student_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $student = $this->repository->find($id);

        if(!$student) {
            throw $this->createNotFoundException("student not found");
        }

        $entityManager->remove($student);
        $entityManager->flush();

        return $this->json(["message" => "student deleted"]);
    }
    
}
