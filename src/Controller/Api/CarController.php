<?php

namespace App\Controller\Api;

use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\{Request, Response};
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class CarController
 * @package App\Controller\Api
 */
class CarController extends BaseApiController
{
    /**
     * @Rest\Get("/cars")
     * @param Request $request
     * @param CarRepository $carRepository
     * @return Response
     */
    public function list(Request $request, CarRepository $carRepository): Response
    {
        $limit = $request->query->get('limit') ?? 20;
        $offset = $request->query->get('offset') ?? 0;
        $cars = $carRepository->findBy([],[], $limit, $offset);
        $meta = [
            'total' => (int)$carRepository->count([]),
            'limit' => (int)$limit,
            'offset' => (int)$offset
        ];
        return $this->handleView($this->view(['cars' => $cars, 'meta' => $meta], Response::HTTP_OK));
    }

    /**
     * @Rest\Get("/cars/{id}")
     * @param int $id
     * @param CarRepository $carRepository
     * @return Response
     */
    public function item(int $id, CarRepository $carRepository): Response
    {
        $car = $carRepository->find($id);
        return $this->handleView($this->view(['car' => $car], Response::HTTP_OK));
    }

    /**
     * @Rest\Post("/cars")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $form = $this->createForm(CarType::class);
        return $this->handleCreate($request, $form);
    }

    /**
     * @param $car
     * @return Response
     */
    public function handleCreateSuccess($car): Response
    {
        return $this->handleView($this->view(['car' => $car], Response::HTTP_CREATED));
    }
}