<?php

namespace Plivo\Action;

use FL\PlivoBundle\Form\Handler\SmsOutgoingFormHandler;
use FL\PlivoBundle\Form\Type\SmsOutgoingFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendMessageAction
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * @var SmsOutgoingFormHandler
     */
    private $handler;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * SendMessageAction constructor.
     *
     * @param FormFactoryInterface   $factory
     * @param SmsOutgoingFormHandler $handler
     * @param \Twig_Environment      $twig
     */
    public function __construct(
        FormFactoryInterface $factory,
        SmsOutgoingFormHandler $handler,
        \Twig_Environment $twig
    ) {
        $this->factory = $factory;
        $this->handler = $handler;
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->factory->create(SmsOutgoingFormType::class);

        $this->handler->handle($form, $request);

        return new Response($this->twig->render('FLPlivoBundle:Message:send.html.twig', [
            'form' => $form->createView(),
        ]), Response::HTTP_OK);
    }
}
