<?php

namespace App\Service;

use App\DTO\StudentDTO;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StudentService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private readonly ResponsibleService $responsibleService,
        private readonly StudentRepository $repository
    )
    {}

    public function get(?int $id = null)
    {
        // get all
        if(!$id) {
            $result = $this->repository->findAll();
            if(empty($result)) {
                throw new NotFoundHttpException('No student found');
            }
            return $result;
        }

        // find by id
        $student = $this->repository->find($id);
        if(!$student) {
            throw new NotFoundHttpException('No student found');
        }
        
        return $student;
    }

    public function create(StudentDTO $dto): Student
    {
        if(!$dto->responsibleId) {
            throw new \Exception('Responsible not found');
        }

        $responsible = $this->responsibleService->get($dto->responsibleId);
        
        $student = new Student();
        $student->setName($dto->name);
        $student->setResponsible($responsible);
        
        $this->entityManager->persist($student);
        $this->entityManager->flush();
        
        return $student;
    }

    public function update(StudentDTO $student): Student
    {  
        $studentFound = $this->entityManager->find(Student::class, $student->id);

        if(!$studentFound) {
            throw new NotFoundHttpException('No student found');
        }
        
        $studentFound->setName($student->name);

        $responsible = $this->responsibleService->get($student->responsibleId);

        if(!$responsible) {
            throw new NotFoundHttpException('No responsible found');
        }
        
        $studentFound->setResponsible($responsible);
        
        $this->entityManager->persist($studentFound);
        $this->entityManager->flush();
        
        return $studentFound;
        
    }

    public function delete(Student $student)
    {
        $this->entityManager->remove($student);
        $this->entityManager->flush();

        return $student;
    }
    
}