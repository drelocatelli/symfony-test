<?php

namespace App\Controller;

use App\Entity\Responsible;
use App\Repository\ResponsibleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ResponsibleController extends AbstractController
{

    public function __construct(private readonly ResponsibleRepository $repository) {}

    #[Route('/responsible', name: 'app_responsible', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $responsibles = $this->repository->findAll();

        return $this->json($responsibles);
    }

    #[Route('/responsible/{id}', name: 'app_responsible_show')]
    public function show(int $id): JsonResponse
    {
        $responsible = $this->repository->find($id);

        return $this->json($responsible);
    }

    #[Route('/responsible', name: 'app_responsible_create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] Responsible $responsible,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
       $entityManager->persist($responsible);
       $entityManager->flush();

       return $this->json($responsible, 201);
    }

    #[Route('/responsible/{id}/students', name: 'app_responsible_students')]
    public function students(int $id): JsonResponse
    {
        $responsible = $this->repository->find($id);

        return $this->json($responsible->getStudents());
    }

    
}
