<?php

namespace App\Controller\Responsible;

use App\Service\ResponsibleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteResponsibleAction extends AbstractController
{

    public function __construct(
        private readonly ResponsibleService $service
    ) {}

    #[Route('/responsible/{id}', name: 'app_responsible_delete', methods: ['DELETE'])]
    public function __invoke(int $id)
    {
        $this->service->delete($id);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

}