<?php

namespace App\Controller\Student;

use App\Entity\Student;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetStudentAction extends AbstractController
{

    public function __construct(
        private readonly StudentService $service
    ) {}

    #[Route('/student/{id}', name: 'app_student_get', methods: ['GET'])]
    public function __invoke(
        Student $student
    ) 
    {
        return $this->json($student, Response::HTTP_OK);
    }

}