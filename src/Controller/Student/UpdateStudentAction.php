<?php

namespace App\Controller\Student;

use App\DTO\StudentDTO;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class UpdateStudentAction extends AbstractController
{

    public function __construct(
        private readonly StudentService $service
    ) {}

    #[Route('/student/{id}', name: 'app_student_update', methods: ['PUT'])]
    public function __invoke(
        #[MapRequestPayload] StudentDTO $student
    ) 
    {
        $data = $this->service->update( $student);
        return $this->json($data, Response::HTTP_OK);
    }

}