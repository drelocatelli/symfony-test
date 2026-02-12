<?php

namespace App\Controller\Responsible;

use App\Service\ResponsibleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetResponsibleAction extends AbstractController
{

    public function __construct(
        private readonly ResponsibleService $service
    )
    {}
    
    #[Route('/responsible/{id}', name: 'app_responsible_create', methods: ['GET'])]
    public function __invoke(
        int $id = null
    )
    {
        $data = $this->service->get($id);
        return $this->json($data, Response::HTTP_OK);
    }
    
}
