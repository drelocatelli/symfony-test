<?php

namespace App\Controller\Responsible;

use App\Entity\Responsible;
use App\Service\ResponsibleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final class CreateResponsibleAction extends AbstractController
{

    public function __construct(
        private readonly ResponsibleService $service
    )
    {}
    
    #[Route('/responsible', name: 'app_responsible_create', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] Responsible $responsible,
    )
    {
        $data = $this->service->create($responsible);
        return $this->json($data, Response::HTTP_CREATED);
    }
}
