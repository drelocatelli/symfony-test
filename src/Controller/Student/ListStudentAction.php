<?php

namespace App\Controller\Student;

use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListStudentAction extends AbstractController
{

    public function __construct(
        private readonly StudentService $service
    ) {}

    #[Route('/student', name: 'app_student_list', methods: ['GET'])]
    public function __invoke() 
    {
        $data = $this->service->get();
        return $this->json($data, Response::HTTP_OK);
    }

}