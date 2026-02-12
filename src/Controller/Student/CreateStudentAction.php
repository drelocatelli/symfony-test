<?php

namespace App\Controller\Student;

use App\DTO\StudentDTO;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class CreateStudentAction extends AbstractController
{

    public function __construct(
        private readonly StudentService $service
    ) {}

    #[Route('/student', name: 'app_student_create', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] StudentDTO $payload
    ) 
    {
        $data = $this->service->create($payload);
        return $this->json($data, Response::HTTP_CREATED);
    }
    
}