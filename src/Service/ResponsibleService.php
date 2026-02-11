<?php

namespace App\Service;

use App\Entity\Responsible;
use Doctrine\ORM\EntityManagerInterface;

class ResponsibleService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {}
    
    public function get(int $id = null): Responsible
    {
        if(!$id) {
            $result = $this->entityManager->getRepository(Responsible::class)->findAll();
            return $result[0] ?? throw new \Exception('No responsible found');
        }
        return $this->entityManager->find(Responsible::class, $id);
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