<?php

namespace App\Service;

use App\Entity\Responsible;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResponsibleService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {}
    
    public function get(int $id = null)
    {
        $repository = $this->entityManager->getRepository(Responsible::class);

        // get all
        if(!$id) {
            $result = $repository->findAll();
            if(empty($result)) {
                throw new NotFoundHttpException('No responsible found');
            }
            return $result;
        }

        // find by id
        $responsible = $repository->find($id);
        if(!$responsible) {
            throw new NotFoundHttpException('No responsible found');
        }
        
        return $responsible;

    }
    
    public function create(Responsible $responsible): Responsible
    {
        $this->entityManager->persist($responsible);
        $this->entityManager->flush();
        
        return $responsible;
    }
    
    public function update(int $id, Responsible $responsible): Responsible
    {

        $responsibleFound = $this->entityManager->find(Responsible::class, $id);
        $responsibleFound->setName($responsible->getName());
        $this->entityManager->persist($responsibleFound);
        $this->entityManager->flush();

        return $responsible;
    }

    public function delete(int $id)
    {
        $responsibleFound = $this->entityManager->find(Responsible::class, $id);
        $this->entityManager->remove($responsibleFound);
        $this->entityManager->flush();
    }
    
}