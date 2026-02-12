<?php

namespace App\Controller\Student;

use App\DTO\StudentDTO;
use App\Entity\Student;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class DeleteStudentAction extends AbstractController
{

    public function __construct(
        private readonly StudentService $service
    ) {}

    #[Route('/student/{id}', name: 'app_student_delete', methods: ['DELETE'])]
    public function __invoke(
        Student $student
    ) 
    {
        $data = $this->service->delete($student);
        return $this->json($data, Response::HTTP_NO_CONTENT);
    }

}