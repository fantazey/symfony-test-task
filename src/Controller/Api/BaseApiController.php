<?php


namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\{Request, Response};
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;

class BaseApiController extends AbstractFOSRestController
{
    /**
     * Handler for POST requests
     * @param Request $request
     * @param FormInterface $form
     * @return Response
     */
    public function handleCreate(Request $request, FormInterface $form): Response
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $object = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($object);
            $em->flush();
            return $this->handleCreateSuccess($object);
        }
        return $this->handleCreateFail($form);
    }

    /**
     * @param $object
     * @return Response
     */
    public function handleCreateSuccess($object): Response
    {
        return $this->handleView($this->view(['status' => 'ok', Response::HTTP_CREATED]));
    }

    /**
     * @param FormInterface $form
     * @return Response
     */
    public function handleCreateFail(FormInterface $form): Response
    {
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }
}