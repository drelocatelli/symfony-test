<?php

namespace App\Controller\Responsible;

use App\Entity\Responsible;
use App\Service\ResponsibleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final class UpdateResponsibleAction extends AbstractController
{

    public function __construct(
        private readonly ResponsibleService $service
    )
    {}
    
    #[Route('/responsible/{id}', name: 'app_responsible_update', methods: ['PUT'])]
    public function __invoke(
        int $id,
        #[MapRequestPayload] Responsible $responsible,
        ?Responsible $existingResponsible = null
    )
    {
        $data = $this->service->update($id, $responsible);
        return $this->json($data, Response::HTTP_CREATED);
    }
    
}
