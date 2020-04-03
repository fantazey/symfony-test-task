<?php

namespace App\Controller\Api;

use App\Entity\Appraisal;
use App\Repository\AppraisalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class AppraisingCarController
 * @package App\Controller\Api
 */
class AppraisingCarController extends AbstractFOSRestController {

    /**
     * @Rest\Get("/appraising-cars")
     * @param Request $request
     * @param AppraisalRepository $appraisalRepository
     * @return Response
     */
    public function list(
        Request $request,
        AppraisalRepository $appraisalRepository
    ): Response {
        $limit = $request->query->get('limit') ?? 20;
        $offset = $request->query->get('offset') ?? 0;
        $items = $appraisalRepository->findUpdatedAppraisals($limit, $offset);
        $meta = [
            'total' => (int)$appraisalRepository->countUpdatedAppraisals(),
            'limit' => (int)$limit,
            'offset' => (int)$offset
        ];
        $response = [];
        /** @var Appraisal $item */
        foreach ($items as $item) {
            $response[] = [
                'id' => $item->getCar()->getId(),
                'car' => $item->getCar(),
                'appraisal' => $item
            ];
        }
        return $this->handleView($this->view(['appraisalCars' => $response, 'meta' => $meta], Response::HTTP_OK));
    }

    /**
     * @Rest\Get("/appraising-cars/{id}")
     * @param int $id
     * @param AppraisalRepository $appraisalRepository
     * @return Response
     */
    public function item(int $id, AppraisalRepository $appraisalRepository): Response {
        $appraisal = $appraisalRepository->findOneBy(['car = ' . $id]);
        if ($appraisal) {
            $data = [
                'appraisalCar' => [
                    'id' => $id,
                    'car' => $appraisal->getCar(),
                    'appraisal' => $appraisal
                ]
            ];
            return $this->handleView($this->view($data, Response::HTTP_OK));
        }
        $this->createNotFoundException('Record with id not found');
    }
}