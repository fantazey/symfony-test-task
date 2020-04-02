<?php

namespace App\Controller\Api;

use App\Form\AppraisalType;
use App\Repository\AppraisalRepository;
use Symfony\Component\HttpFoundation\{Request, Response};
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class AppraisalController
 * @package App\Controller\Api
 */
class AppraisalController extends BaseApiController
{
    /**
     * @Rest\Get("/appraisals/{id}")
     * @param int id
     * @param AppraisalRepository $appraisalRepository
     * @return Response
     */
    public function item(int $id, AppraisalRepository $appraisalRepository): Response{
        $appraisal = $appraisalRepository->find($id);
        return $this->handleView($this->view(['appraisal' => $appraisal], Response::HTTP_OK));
    }

    /**
     * @Rest\Post("/appraisals")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(AppraisalType::class);
        return $this->handleCreate($request, $form);
    }

    /**
     * @param $appraisal
     * @return Response
     */
    public function handleCreateSuccess($appraisal): Response
    {
        return $this->handleView($this->view(['appraisal' => $appraisal], Response::HTTP_OK));
    }
}