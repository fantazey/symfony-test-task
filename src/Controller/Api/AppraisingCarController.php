<?php

namespace App\Controller\Api;

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
     * @Rest\Get("/apprasing-cars")
     * @param Request $request
     * @return Response
     */
    public function list(Request $request): Response {
        $data = [
            'test' => [
                'test1' => 1,
                'test2' => 'asdasdas'
            ]
        ];
        return $this->handleView($this->view($data));
    }
}