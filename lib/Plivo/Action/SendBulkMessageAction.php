<?php

namespace Plivo\Action;

use FL\PlivoBundle\Form\Handler\BulkSmsOutgoingFormHandler;
use FL\PlivoBundle\Form\Type\BulkSmsOutgoingFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendBulkMessageAction
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * @var BulkSmsOutgoingFormHandler
     */
    private $handler;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * SendBulkMessageAction constructor.
     * @param FormFactoryInterface $factory
     * @param BulkSmsOutgoingFormHandler $handler
     * @param \Twig_Environment $twig
     */
    public function __construct(
        FormFactoryInterface $factory,
        BulkSmsOutgoingFormHandler $handler,
        \Twig_Environment $twig
    ) {
        $this->factory = $factory;
        $this->handler = $handler;
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->factory->create(BulkSmsOutgoingFormType::class);

        $this->handler->handle($form, $request);

        return new Response($this->twig->render('FLPlivoBundle:Message:send-bulk.html.twig', [
            'form' => $form->createView(),
        ]), Response::HTTP_OK);
    }
}
